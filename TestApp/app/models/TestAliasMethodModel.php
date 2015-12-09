<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Inject;
use WebStream\Annotation\Alias;

class TestAliasMethodModel extends CoreModel
{
    /**
     * @Inject
     * @Alias(name="aliasMethod3");
     */
    public function originMethod3()
    {
        echo "originMethod3";
    }

    /**
     * @Inject
     * @Alias(name="aliasMethod7");
     */
    public function originMethod7()
    {
        // 決して呼ばれない
    }

    public function aliasMethod7()
    {
        echo "originMethod7";
    }
}
