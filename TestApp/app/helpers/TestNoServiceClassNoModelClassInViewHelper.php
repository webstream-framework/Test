<?php
namespace WebStream\Test\IntegrationTest\Helper;

use WebStream\Core\CoreHelper;
use WebStream\Annotation\ExceptionHandler;

class TestNoServiceClassNoModelClassInViewHelper extends CoreHelper
{
    public function noModel($model)
    {
        $model->undefied();
    }

    /**
     * @ExceptionHandler("\Exception")
     */
    public function handle($params)
    {
        echo $params["exception"];
    }
}
