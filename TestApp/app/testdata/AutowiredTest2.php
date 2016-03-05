<?php
namespace WebStream\Test\TestData;

use WebStream\Core\CoreInterface;
use WebStream\Annotation\Base\IAnnotatable;
use WebStream\Annotation\Autowired;
use WebStream\Module\Container;

class AutowiredTest2 implements CoreInterface, IAnnotatable
{
    /**
     * @Autowired(type="\Dummy\Test")
     */
    private $dummy;

    public function __construct(Container $container)
    {
    }

    public function __destruct()
    {
    }

    public function __initialize(Container $container)
    {
    }

    public function __customAnnotation(array $annotation)
    {
    }
}
