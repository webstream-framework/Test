<?php
namespace WebStream\Test\TestData;

use WebStream\Core\CoreInterface;
use WebStream\Annotation\Base\IAnnotatable;
use WebStream\Annotation\Autowired;
use WebStream\Module\Container;

class AutowiredTest8 implements CoreInterface, IAnnotatable
{
    /**
     * @Autowired(value="name3")
     */
    private $name3 = "default3";

    /**
     * @Autowired(value="name4")
     */
    private $name4;

    public function __construct(Container $container) {}

    public function __destruct() {}

    public function __initialize(Container $container) {}

    public function getName3()
    {
        return $this->name3;
    }

    public function getName4()
    {
        return $this->name4;
    }
}
