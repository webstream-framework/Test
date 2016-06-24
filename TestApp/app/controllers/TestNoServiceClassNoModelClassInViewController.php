<?php
namespace WebStream\Test\IntegrationTest\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;

class TestNoServiceClassNoModelClassInViewController extends CoreController
{
    /**
     * @Template("basic.tmpl")
     */
    public function test1()
    {
    }
}
