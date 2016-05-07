<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestTwigTemplateController extends CoreController
{
    /**
     * @Template("index1.twig", engine="twig")
     */
    public function index1()
    {
        // twigテンプレートを使用
    }

    /**
     * @Template("index2.twig", engine="twig")
     */
    public function index2()
    {
        // modelの内容を描画できること
    }

    /**
     * @Template("index3.twig", engine="twig")
     */
    public function index3()
    {
        // DBの値を描画できること
    }

    /**
     * @Template("index4.twig", engine="twig")
     */
    public function index4()
    {
        // sharedテンプレートを使用できること
    }

    /**
     * @Template("index5.twig", engine="twig")
     */
    public function index5()
    {
        // sharedに同名のファイルがある場合、pageName配下ディレクトリが優先されること
    }

    /**
     * @Template("index6.twig", engine="twig")
     */
    public function index6()
    {
        // partsテンプレートを使用できること
    }

    /**
     * @Template("undefined.twig", engine="twig")
     */
    public function error1()
    {
        // 存在しないテンプレート
    }
}
