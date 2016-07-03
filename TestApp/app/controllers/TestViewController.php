<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;
use WebStream\Annotation\Header;
use WebStream\Annotation\ExceptionHandler;

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

    /**
     * @Template("basic_encode_html.tmpl")
     */
    public function basicEncodeHtml()
    {
        $this->TestView->setCode("<p>a</p>");
    }

    /**
     * @Template("basic_encode_javascript.tmpl")
     */
    public function basicEncodeJavascript()
    {
        $this->TestView->setCode("<script>alert('a');</script>");
    }

    /**
     * @Template("basic_encode_xml.tmpl")
     * @Header(contentType="xml")
     */
    public function basicEncodeXml()
    {
        $this->TestView->setCode("<test>a</test>");
    }

    /**
     * @Template("basic_in_helper.tmpl")
     */
    public function basicTemplateInHelper()
    {
        $this->TestView->setTmplName("parts.tmpl");
    }

    /**
     * @Template("basic_async.tmpl")
     */
    public function basicAsync()
    {
        $this->TestView->setPath("/view/basic");
    }

    /**
     * @ExceptionHandler("\Exception")
     */
    public function handle($params)
    {
        echo $params["exception"];
    }
}
