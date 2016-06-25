<?php
namespace WebStream\Test\IntegrationTest\Helper;

use WebStream\Core\CoreHelper;

class TestViewHelper extends CoreHelper
{
    public function getPartsTemplate($model)
    {
        return $model->tmplName;
    }
}
