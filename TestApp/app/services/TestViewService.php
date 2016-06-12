<?php
namespace WebStream\Test\IntegrationTest\Service;

use WebStream\Core\CoreService;
use WebStream\Module\PropertyProxy;

class TestViewService extends CoreService
{
    use PropertyProxy;

    public function setTmplName($tmplName)
    {
        $this->tmplName = $tmplName;
    }

    public function getTmplName()
    {
        return $this->tmplName;
    }
}
