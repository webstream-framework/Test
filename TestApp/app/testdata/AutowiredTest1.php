<?php
namespace WebStream\Test\TestData;

use WebStream\Core\CoreInterface;
use WebStream\Annotation\Base\IAnnotatable;
use WebStream\Annotation\Autowired;
use WebStream\Module\Container;

class AutowiredTest1 implements CoreInterface, IAnnotatable
{
    /**
     * @Autowired(type="\WebStream\Test\TestData\AutowiredTestType")
     */
    private $instance;

    /**
     * @Autowired(value="kotori@lovelive.com")
     */
    private $mail;

    /**
     * @Autowired(value=17)
     */
    private $age;

    public function __construct(Container $container) {}

    public function __destruct() {}

    public function __initialize(Container $container) {}

    public function getInstance()
    {
        return $this->instance;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getAge()
    {
        return $this->age;
    }
}
