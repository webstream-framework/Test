<?php
namespace WebStream\Core;

use WebStream\Delegate\Resolver;
use WebStream\Module\Utility;
use WebStream\Module\Logger;
use WebStream\Module\PropertyProxy;
use WebStream\Module\Container;
use WebStream\Annotation\Inject;
use WebStream\Annotation\Filter;

/**
 * CoreControllerクラス
 * @author Ryuichi TANAKA.
 * @since 2011/09/11
 * @version 0.4.2
 */
class CoreController implements CoreInterface
{
    use Utility;
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
     * {@inheritdoc}
     */
    final public function __construct(Container $container)
    {
        Logger::debug("Controller start.");
        $this->request   = $container->request;
        $this->response  = $container->response;
        $this->session   = $container->session;
        $this->coreDelegator = $container->coreDelegator;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        Logger::debug("Controller end.");
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
     * @Inject
     * @Filter(type="initialize")
     */
    public function __initialize(Container $container)
    {
        $pageName = $this->coreDelegator->getPageName();
        $resolver = new Resolver($container);
        $this->{$pageName} = $resolver->runService() ?: $resolver->runModel();
    }
}
