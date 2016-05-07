<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestHelperController extends CoreController
{
    /**
     * @Template("base1.tmpl")
     */
    public function help1()
    {
    }

    /**
     * @Template("base2.tmpl")
     */
    public function help2()
    {
        $this->TestHelper->setName("μ's");
    }

    /**
     * @Template("base3.tmpl")
     */
    public function help3()
    {
        $this->TestHelper->setName("LilyWhite");
    }

    /**
     * @Template("base4.tmpl")
     */
    public function help4()
    {
        $this->TestHelper->setName("BiBi");
    }

    /**
     * @Template("base5.tmpl")
     */
    public function help5()
    {
    }

    /**
     * @Template("base6.tmpl")
     */
    public function help6()
    {
        $this->TestHelper->setMap([
            "name" => "honoka",
            "age" => 16
        ]);
    }

    /**
     * @Template("base7.tmpl")
     */
    public function help7()
    {
    }

    /**
     * @Template("base8.tmpl")
     */
    public function help8()
    {
    }

    public function help7Async()
    {
        echo "<p>async</p>";
    }

    public function help8Async2()
    {
        echo "nico";
    }

    public function help8Async3()
    {
        echo "maki";
    }
}
