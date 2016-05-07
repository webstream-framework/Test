<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Header;
use WebStream\Annotation\Template;

class TestHeaderController extends TestParentHeaderController
{
    /**
     * @Template("html.tmpl")
     * @Header(contentType="html")
     */
    public function test1()
    {
    }

    /**
     * @Template("xml.tmpl")
     * @Header(contentType="xml")
     */
    public function test2()
    {
    }

    /**
     * @Template("atom.tmpl")
     * @Header(contentType="atom")
     */
    public function test3()
    {
    }

    /**
     * @Template("rss.tmpl")
     * @Header(contentType="rss")
     */
    public function test4()
    {
    }

    /**
     * @Template("rdf.tmpl")
     * @Header(contentType="rdf")
     */
    public function test5()
    {
    }

    /**
     * @Header(allowMethod="get")
     */
    public function test6()
    {
    }

    /**
     * @Header(allowMethod="GET")
     */
    public function test7()
    {
    }

    /**
     * @Header(allowMethod="post")
     */
    public function test8()
    {
    }

    /**
     * @Header(allowMethod="POST")
     */
    public function test9()
    {
    }

    /**
     * @Header(allowMethod={"GET","POST"})
     */
    public function test10()
    {
    }

    /**
     * @Header(allowMethod={"POST","PUT"})
     */
    public function test11()
    {
    }

    /**
     * @Header(contentType="html", allowMethod="GET")
     */
    public function test12()
    {
    }

    /**
     * @Header(contentType="xml", allowMethod="POST")
     */
    public function test13()
    {
    }

    /**
     * @Header(contentType="dummy")
     */
    public function test14()
    {
    }

    /**
     * @Header(allowMethod="dummy")
     */
    public function test15()
    {
    }
}
