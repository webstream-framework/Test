<?php
namespace WebStream\Test\TestData\Sample\App\Service;

use WebStream\Core\CoreService;
use WebStream\Annotation\Inject;
use WebStream\Annotation\Alias;

class TestAliasMethodService extends CoreService
{
    /**
     * @Inject
     * @Alias(name="aliasMethod2")
     */
    public function originMethod2()
    {
        echo "originMethod2";
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod6")
     */
    public function originMethod6()
    {
        // 決して呼ばれない
    }

    public function aliasMethod6()
    {
        echo "originMethod6";
    }
}
