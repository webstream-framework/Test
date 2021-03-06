<?php
namespace WebStream\Module;

use WebStream\DI\Injector;

/**
 * HttpClient
 * @author Ryuichi TANAKA.
 * @since 2010/10/20
 * @version 0.7
 */
class HttpClient
{
    use Injector;

    /**
     * @var array レスポンスヘッダ
     */
    private $responseHeader;

    /**
     * @var int レスポンスヘッダ
     */
    private $status_code;

    /**
     * @var string コンテントタイプ
     */
    private $content_type;

    /**
     * @var int タイムアウト時間
     */
    private $timeout;

    /**
     * @var string PROXYホスト名
     */
    private $proxy_host;

    /**
     * @var int PROXYポート番号
     */
    private $proxy_port;

    /**
     * @var string Basic認証ID
     */
    private $basic_auth_id;

    /**
     * @var string Basic認証パスワード
     */
    private $basic_auth_password;

    /**
     * @var string デフォルトタイムアウト時間
     */
    const DEFAULT_TIMEOUT = 3;

    /**
     * コンストラクタ
     * @param array<string> オプションパラメータ
     */
    public function __construct($options = [])
    {
        $this->timeout             = $this->getOptionParameter($options, "timeout", self::DEFAULT_TIMEOUT);
        $this->proxy_host          = $this->getOptionParameter($options, "proxy_host");
        $this->proxy_port          = $this->getOptionParameter($options, "proxy_port");
        $this->basic_auth_id       = $this->getOptionParameter($options, "basic_auth_id");
        $this->basic_auth_password = $this->getOptionParameter($options, "basic_auth_password");
        // HttpClientはどのレイヤからも呼び出し可能なので、明示的なロガー注入を必須としない
        $this->logger = new class() { public function __call($name, $args) {} };
    }

    /**
     * ステータスコードを返却する
     * @return int ステータスコード
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * コンテントタイプを返却する
     * @return string コンテントタイプ
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * レスポンスヘッダを返却する
     * @return array レスポンスヘッダ
     */
    public function getResponseHeader()
    {
        return $this->responseHeader;
    }

    /**
     * GETリクエストを発行する
     * @param string URL
     * @param array<mixed> リクエストパラメータ
     * @param array リクエストヘッダ
     * @return string レスポンス
     */
    public function get($url, $params = "", $headers = [])
    {
        return $this->http($url, $headers, $params, "GET");
    }

    /**
     * POSTリクエストを発行する
     * @param string URL
     * @param array<mixed> リクエストパラメータ
     * @param array リクエストヘッダ
     * @return string レスポンス
     */
    public function post($url, $params, $headers = [])
    {
        return $this->http($url, $headers, $params, "POST");
    }

    /**
     * PUTリクエストを発行する
     * @param string URL
     * @param array<mixed> リクエストパラメータ
     * @param array リクエストヘッダ
     * @return string レスポンス
     */
    public function put($url, $params, $headers = [])
    {
        return $this->http($url, $headers, $params, "PUT");
    }

    /**
     * PROXY設定をする
     * @param array<string> リクエストコンテント
     */
    private function proxy(&$request)
    {
        // 「http://」は「tcp://」に、「https://」は「ssl://」に置換する
        $host = $this->proxy_host;
        $host = preg_replace('/^http(:\/\/.+)$/', 'tcp${1}', $host);
        $host = preg_replace('/^https(:\/\/.+)$/', 'ssl${1}', $host);
        $request["proxy"] = $host . ":" . strval($this->proxy_port);
        $request["request_fulluri"] = true;
    }

    /**
     * Basic認証を設定する
     * @param array リクエストヘッダ
     */
    private function basicAuth(&$headers)
    {
        $headers[] = "Authorization: Basic " .
            base64_encode($this->basic_auth_id . ":" . $this->basic_auth_password);
    }

    /**
     * HTTP通信を実行する
     * @param string URL
     * @param array リクエストヘッダ
     * @param array<string> リクエストパラメータ
     * @param string 実行するRESTメソッド
     * @return string レスポンス
     */
    private function http($url, $headers, $params, $method)
    {
        if (!empty($params)) {
            $params = http_build_query($params);
            // GETの場合はstream_context_createでクエリを渡しても有効にならないため
            // URLにクエリストリングを付けることで対処
            if ($method === "GET") {
                $url .= "?" . $params;
            }
        }
        if (empty($headers) && ($method === "POST" || $method === "PUT")) {
            $contentLength = !is_string($params) ? 0 : strlen($params);
            $headers = [
                "Content-Type: application/x-www-form-urlencoded",
                "Content-Length: " . $contentLength
            ];
        }
        $request = [
            "method"  => $method,
            "content" => $params,
            "timeout" => $this->timeout
        ];
        // Proxy設定
        if ($this->proxy_host && $this->proxy_port) {
            $this->proxy($request);
        }
        // Basic認証
        if ($this->basic_auth_id && $this->basic_auth_password) {
            $this->basicAuth($headers);
        }
        if (!empty($headers)) {
            $request["header"] = implode("\r\n", $headers);
        }
        // レスポンス
        $response = @file_get_contents($url, false, stream_context_create(["http" => $request]));

        if (!isset($http_response_header)) {
            $hasHeader = @get_headers($url);
            if ($hasHeader === false) { // ヘッダを持たない場合、存在しないURL
                $this->status_code = 404;
                $this->logger->error("URL not found: " . $url);
            } else { // ヘッダを持つ場合はタイムアウトが発生
                $this->status_code = 408;
                $this->logger->error("Request timeout: " . $url);
            }

            return null;
        } else {
            $this->responseHeader = $http_response_header;
        }

        // ヘッダ情報を取得
        foreach ($this->responseHeader as $value) {
            // Content-Type
            if (preg_match('/^Content-Type:\s.+/', $value)) {
                $this->content_type = $value;
            }
            // ステータスコード
            if (preg_match('/^HTTP\/.+\s([0-9]{3})/', $this->responseHeader[0], $matches)) {
                $this->status_code = intval($matches[1]);
            }
        }

        if ($this->status_code === 200) { // HTTP通信の結果が200
            $this->logger->info("HTTP {$method} success({$this->status_code}): {$url}");

            return $response;
        } else { // HTTP通信の結果が200以外
            if ($this->status_code === null) {
                $this->status_code = 500;
            }
            $this->logger->error("HTTP {$method} failure({$this->status_code}): {$url}");

            return null;
        }
    }

    /**
     * 配列から安全に値を取得する
     * @param array<string> オプション配列
     * @param string 配列キー
     * @param string or Integer デフォルト値
     * @return mixed オプション配列の値
     */
    private function getOptionParameter($options, $key, $default_value = null)
    {
        return array_key_exists($key, $options) ? $options[$key] : $default_value;
    }
}
