<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestViewController extends CoreController
{
    /**
     * @Template("basic.tmpl")
     */
    public function basic()
    {
        $this->TestView->setTmplName("basic");
    }

    /**
     * @Template("twig.twig", engine="twig")
     */
    public function twig()
    {
        $this->TestView->setTmplName("twig");
    }

    /**
     * @Template("basic_parts.tmpl")
     */
    public function basicParts()
    {
    }
}
