<?php
namespace WebStream\Test;

use WebStream\Module\Utility\ApplicationUtils;
use WebStream\Module\Utility\CommonUtils;
use WebStream\Module\Utility\FileUtils;
use WebStream\Module\Utility\SecurityUtils;
use WebStream\Log\Logger;
use WebStream\Test\DataProvider\UtilityProvider;

require_once 'TestBase.php';
require_once 'TestConstant.php';
require_once 'DataProvider/UtilityProvider.php';

/**
 * UtilityTest
 * @author Ryuichi TANAKA.
 * @since 2012/01/15
 * @version 0.4
 */
class UtilityTest extends TestBase
{
    use CommonUtils, FileUtils;
    use UtilityProvider, TestConstant;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * 正常系
     * プロジェクトルートパスが取得できること
     * @test
     */
    public function okGetProjectRoot()
    {
        $this->assertEquals($this->getProjectRootPath(), $this->getApplicationRoot());
    }

    /**
     * 正常系
     * ファイル検索できること
     * @test
     * @dataProvider fileSearchIteratorProvider
     */
    public function okFileSearch($path)
    {
        $classpath = $this->getApplicationRoot() . $path;
        $iterator = $this->getFileSearchIterator($this->getApplicationRoot());
        $isOk = false;
        foreach ($iterator as $filepath => $fileObject) {
            if ($filepath === $classpath) {
                $isOk = true;
            }
        }

        $this->assertTrue($isOk);
    }

    /**
     * 正常系
     * ファイルから名前空間を取得できること
     * @test
     * @dataProvider readNamespaceProvider
     */
    public function okReadNamespace($filepath, $namespace)
    {
        $path = $this->getNamespace($this->getProjectRootPath() . $filepath);
        $this->assertEquals($path, $namespace);
    }

    /**
     * 正常系
     * 名前空間がないファイルの場合、名前空間が取得できないこと
     * @test
     * @dataProvider readNoNamespaceProvider
     */
    public function okReadNoNamespace($filepath)
    {
        $filepath = $this->getProjectRootPath() . $filepath;
        $this->assertFileExists($filepath);
        $path = $this->getNamespace($filepath);
        $this->assertNull($path);
    }

    /**
     * 正常系
     * 要素が存在する場合、trueを返すこと
     * @test
     * @dataProvider customInArrayProvider
     */
    public function okCustomInArray($target, $list)
    {
        $this->assertTrue($this->inArray($target, $list));
    }
}
