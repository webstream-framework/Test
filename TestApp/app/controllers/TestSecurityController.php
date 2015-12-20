<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Template;
use WebStream\Annotation\CsrfProtection;

class TestSecurityController extends CoreController
{
    /**
     * @Template("index.tmpl")
     */
    public function testCsrf()
    {
    }

    /**
     * @Template("csrf_get.tmpl")
     */
    public function testCsrfGet()
    {
    }

    /**
     * @Template("csrf_post.tmpl")
     */
    public function testCsrfPost()
    {
    }

    /**
     * @CsrfProtection
     * @Template("csrf_post_view.tmpl")
     */
    public function testCsrfPostView()
    {
    }

    /**
     * @Template("csrf_helper.tmpl")
     */
    public function testCsrfHelper()
    {
    }
}
