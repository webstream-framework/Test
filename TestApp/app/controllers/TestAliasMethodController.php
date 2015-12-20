<?php
namespace WebStream\Test\TestData\Sample\App\Controller;

use WebStream\Core\CoreController;
use WebStream\Annotation\Alias;
use WebStream\Annotation\Template;

class TestAliasMethodController extends CoreController
{
    /**
     * @Alias(name="aliasMethod1")
     */
    public function originMethod1()
    {
        echo "originMethod1";
    }

    /**
     * @Alias(name="aliasMethod2")
     */
    public function originMethod2()
    {
        $this->TestAliasMethod->aliasMethod2();
    }

    /**
     * @Alias(name="aliasMethod3")
     */
    public function originMethod3()
    {
        $this->TestAliasMethod->aliasMethod3();
    }

    /**
     * @Alias(name="aliasMethod4")
     * @Template("alias_method.tmpl")
     */
    public function originMethod4()
    {
    }

    /**
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
     * @Alias(name="aliasMethod6")
     */
    public function originMethod6()
    {
        $this->TestAliasMethod->aliasMethod6();
    }

    /**
     * @Alias(name="aliasMethod7")
     */
    public function originMethod7()
    {
        $this->TestAliasMethod->aliasMethod7();
    }

    /**
     * @Alias(name="aliasMethod8");
     * @Template("origin_method.tmpl")
     */
    public function originMethod8()
    {
    }
}
