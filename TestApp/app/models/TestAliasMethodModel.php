<?php
namespace WebStream\Test\TestData\Sample\App\Model;

use WebStream\Core\CoreModel;
use WebStream\Annotation\Alias;

class TestAliasMethodModel extends CoreModel
{
    /**
     * @Alias(name="aliasMethod3")
     */
    public function originMethod3()
    {
        echo "originMethod3";
    }

    /**
     * @Alias(name="aliasMethod7")
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
