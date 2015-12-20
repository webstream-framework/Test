<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestViewModelInServiceController extends CoreController
{
    /**
     * @Template("service1.tmpl")
     */
    public function service1()
    {
        $this->TestViewModelInService->service1();
    }

    /**
     * @Template("service2.tmpl")
     */
    public function service2()
    {
        $this->TestViewModelInService->service2();
    }
}
