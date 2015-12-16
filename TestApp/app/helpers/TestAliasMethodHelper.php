<?php
namespace WebStream\Test\TestData\Sample\App\Helper;

use WebStream\Core\CoreHelper;
use WebStream\Annotation\Inject;
use WebStream\Annotation\Alias;

class TestAliasMethodHelper extends CoreHelper
{
    /**
     * @Inject
     * @Alias(name="aliasMethod4")
     */
    public function originMethod4()
    {
        echo "originMethod4";
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod8")
     */
    public function originMethod8()
    {
        // 決して呼ばれない
    }

    public function aliasMethod8()
    {
        echo "originMethod8";
    }
}
