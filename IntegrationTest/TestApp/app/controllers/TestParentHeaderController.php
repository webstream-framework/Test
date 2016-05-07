<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Header;
use WebStream\Annotation\Template;

class TestParentHeaderController extends CoreController
{
    /**
     * @Template("html.tmpl")
     * @Header(contentType="html")
     */
    public function test16()
    {
    }
}
