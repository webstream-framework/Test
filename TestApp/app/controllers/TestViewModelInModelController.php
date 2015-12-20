<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestViewModelInModelController extends CoreController
{
    /**
     * @Template("model1.tmpl")
     */
    public function model1()
    {
        $this->TestViewModelInModel->model1();
    }

    /**
     * @Template("model2.tmpl")
     */
    public function model2()
    {
        $this->TestViewModelInModel->model2();
    }
}
