<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Inject;
use WebStream\Annotation\Alias;
use WebStream\Annotation\Template;

class TestAliasMethodController extends CoreController
{
    /**
     * @Inject
     * @Alias(name="aliasMethod1")
     */
    public function originMethod1()
    {
        echo "originMethod1";
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod2")
     */
    public function originMethod2()
    {
        $this->TestAliasMethod->aliasMethod2();
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod3")
     */
    public function originMethod3()
    {
        $this->TestAliasMethod->aliasMethod3();
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod4")
     * @Template("alias_method.tmpl")
     */
    public function originMethod4()
    {
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod5")
     */
    public function originMethod5()
    {
        // 決して呼ばれない
    }

    public function aliasMethod5()
    {
        echo "originMethod5";
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod6")
     */
    public function originMethod6()
    {
        $this->TestAliasMethod->aliasMethod6();
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod7")
     */
    public function originMethod7()
    {
        $this->TestAliasMethod->aliasMethod7();
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod8");
     * @Template("origin_method.tmpl")
     */
    public function originMethod8()
    {
    }
}
