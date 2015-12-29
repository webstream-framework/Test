<?php
namespace WebStream\Test\TestData;

use WebStream\Annotation\Autowired;

class AutowiredTest7 extends AutowiredTest8
{
    /**
     * @Autowired(value="name1")
     */
    private $name = "default1";

    /**
     * @Autowired(value="name2")
     */
    private $name2;

    public function getName()
    {
        return $this->name;
    }

    public function getName2()
    {
        return $this->name2;
    }

    public function getName3()
    {
        return parent::getName3();
    }

    public function getName4()
    {
        return parent::getName4();
    }
}
