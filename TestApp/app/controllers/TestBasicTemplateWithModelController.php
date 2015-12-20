<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestBasicTemplateWithModelController extends CoreController
{
    /**
     * @Template("index1.tmpl")
     */
    public function index1()
    {
        // modelオブジェクトが取得できること
    }
}
