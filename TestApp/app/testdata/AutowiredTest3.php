<?php
namespace WebStream\Test\TestData;

use WebStream\Core\CoreInterface;
use WebStream\Annotation\Base\IAnnotatable;
use WebStream\Annotation\Autowired;
use WebStream\Module\Container;

class AutowiredTest3 implements CoreInterface, IAnnotatable
{
    /**
     * @Autowired(value=AutowiredConstant::HONOKA)
     */
    private $name;

    /**
     * @Autowired(value=AutowiredConstant::MEMBER_NUM)
     */
    private $memberNum;

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

    public function getName()
    {
        return $this->name;
    }

    public function getMemberNum()
    {
        return $this->memberNum;
    }
}
