<?php
namespace WebStream\Core;

use WebStream\Delegate\Resolver;
use WebStream\Module\PropertyProxy;
use WebStream\Module\Container;
use WebStream\Annotation\Filter;
use WebStream\Annotation\Base\IAnnotatable;

/**
 * CoreControllerクラス
 * @author Ryuichi TANAKA.
 * @since 2011/09/11
 * @version 0.4.2
 */
class CoreController implements CoreInterface, IAnnotatable
{
    use PropertyProxy;

    /**
     * @var Session セッション
     */
    protected $session;

    /**
     * @var Request リクエスト
     */
    protected $request;

    /**
     * @var Response レスポンス
     */
    private $response;

    /**
     * @var CoreDelegator コアデリゲータ
     */
    private $coreDelegator;

    /**
     * @var array<mixed> カスタムアノテーション
     */
    protected $annotation;

    /**
     * @var LoggerAdapter ロガー
     */
    protected $logger;

    /**
     * {@inheritdoc}
     */
    final public function __construct(Container $container)
    {
        $this->request   = $container->request;
        $this->response  = $container->response;
        $this->session   = $container->session;
        $this->logger    = $container->logger;
        $this->coreDelegator = $container->coreDelegator;
        $this->logger->debug("Controller start.");
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        $this->logger->debug("Controller end.");
        $this->__clear();
    }

    /**
     * 静的ファイルを読み込む
     * @param string 静的ファイルパス
     */
    final public function __callStaticFile($filepath)
    {
        $this->coreDelegator->getView()->__file($filepath);
    }

    /**
     * カスタムアノテーション情報を設定する
     * @param array<mixed> カスタムアノテーション情報
     */
    final public function __customAnnotation(array $annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * 初期化処理
     * @Filter(type="initialize")
     */
    public function __initialize(Container $container)
    {
        $pageName = $this->coreDelegator->getPageName();
        $resolver = new Resolver($container);
        $this->{$pageName} = $resolver->runService() ?: $resolver->runModel();
    }
}
