<?php
namespace WebStream\Core;

use WebStream\Delegate\Resolver;
use WebStream\Module\Container;
use WebStream\Module\PropertyProxy;
use WebStream\Annotation\Filter;
use WebStream\Annotation\Base\IAnnotatable;

/**
 * CoreService
 * @author Ryuichi TANAKA.
 * @since 2011/09/11
 * @version 0.4.1
 */
class CoreService implements CoreInterface, IAnnotatable
{
    use PropertyProxy;

    /**
     * @var Container コンテナ
     */
    private $container;

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
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $container->logger;
        $this->logger->debug("Service start.");
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        $this->logger->debug("Service end.");
        $this->__clear();
    }

    /**
     * {@inheritdoc}
     * @Filter(type="initialize")
     */
    public function __initialize(Container $container)
    {
        $coreDelegator = $container->coreDelegator;
        $pageName = $coreDelegator->getPageName();
        $resolver = new Resolver($container);
        $this->{$pageName} = $resolver->runModel();
    }

    /**
     * {@inheritdoc}
     */
    public function __customAnnotation(array $annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * Controllerから存在しないメソッドが呼ばれたときの処理
     * @param string メソッド名
     * @param array 引数の配列
     * @return 実行結果
     */
    final public function __call($method, $arguments)
    {
        $coreDelegator = $this->container->coreDelegator;
        $pageName = $coreDelegator->getPageName();

        return $this->{$pageName}->run($method, $arguments);
    }
}
