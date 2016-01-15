<?php
namespace WebStream\Test\UnitTest;

use WebStream\Module\ClassLoader;

require_once dirname(__FILE__) . '/TestBase.php';

/**
 * ClassLoaderクラスのテストクラス
 * @author Ryuichi TANAKA.
 * @since 2013/09/02
 * @version 0.4
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * 正常系
     * coreディレクトリクラスがオートロード出来ること
     * @test
     */
    public function okAutoLoadClass()
    {
        $instance = new \WebStream\Test\TestData\ClassLoaderTestClass();
        $this->assertEquals($instance->getName(), "hoge");
    }

    /**
     * 正常系
     * coreディレクトリトレイトがオートロード出来ること
     * @test
     */
    public function okAutoLoadTrait()
    {
        $instance = new \WebStream\Test\TestData\ClassLoaderTestTraitClass();
        $this->assertEquals($instance->getName(), "hoge");
    }

    /**
     * 正常系
     * appディレクトリクラスがオートロード出来ること
     * @test
     */
    public function okAutoLoadModuleWithoutNamespace()
    {
        new \WebStream\Test\TestData\Sample\App\Library\SampleLibrary();
        $this->assertTrue(true);
    }

    /**
     * 正常系
     * クラスを静的にロード出来ること
     * @test
     */
    public function okLoadClass()
    {
        $classLoader = new ClassLoader();
        $list = $classLoader->load("ClassLoaderTestClassStaticLoad");
        $instance = new \WebStream\Test\TestData\ClassLoaderTestClassStaticLoad();
        $this->assertTrue($instance instanceof \WebStream\Test\TestData\ClassLoaderTestClassStaticLoad);
        $this->assertTrue(count($list) === 1);
    }

    /**
     * 正常系
     * クラスを静的に複数ロード出来ること
     * @test
     */
    public function okLoadMultipleClass()
    {
        $classLoader = new ClassLoader();
        $list = $classLoader->load(["ClassLoaderTestClassStaticLoadMultiple1", "ClassLoaderTestClassStaticLoadMultiple2"]);
        $instance1 = new \WebStream\Test\TestData\ClassLoaderTestClassStaticLoadMultiple1();
        $instance2 = new \WebStream\Test\TestData\ClassLoaderTestClassStaticLoadMultiple2();
        $this->assertTrue($instance1 instanceof \WebStream\Test\TestData\ClassLoaderTestClassStaticLoadMultiple1);
        $this->assertTrue($instance2 instanceof \WebStream\Test\TestData\ClassLoaderTestClassStaticLoadMultiple2);
        $this->assertTrue(count($list) === 2);
    }

    /**
     * 正常系
     * 検索結果で複数のファイルが該当した場合、全てロードされること
     * @test
     */
    public function okSearchMultipleFile()
    {
        $classLoader = new ClassLoader();
        $list = $classLoader->load("UtilityFileSearch");
        $instance1 = new \WebStream\Test\TestData\UtilityFileSearch1();
        $instance2 = new \WebStream\Test\TestData\UtilityFileSearch2();
        $this->assertTrue($instance1 instanceof \WebStream\Test\TestData\UtilityFileSearch1);
        $this->assertTrue($instance2 instanceof \WebStream\Test\TestData\UtilityFileSearch2);
    }

    /**
     * 正常系
     * クラス以外のファイルをインポートできること
     * @test
     */
    public function okImportFile()
    {
        $classLoader = new ClassLoader();
        $classLoader->import("app/testdata/ClassLoaderTestImport.php");
        $this->assertTrue(function_exists("testImport"));
    }

    /**
     * 正常系
     * クラス以外のファイルを全てインポートできること
     * @test
     */
    public function okImportAllFile()
    {
        $classLoader = new ClassLoader();
        $classLoader->importAll("app/testdata/ClassLoaderTest");
        $this->assertTrue(function_exists("testImportAll1"));
        $this->assertTrue(function_exists("testImportAll2"));
    }

    /**
     * 正常系
     * インポートするファイルをフィルタリングできること
     * @test
     */
    public function okImportAllWithFilter()
    {
        $classLoader = new ClassLoader();
        $classLoader->importAll("app/testdata/ClassLoaderFilterTest", function ($filepath) {
            return strpos($filepath, "ClassLoaderTestFilter1") !== false;
        });
        $this->assertTrue(function_exists("testImportAllFilter1"));
        $this->assertFalse(function_exists("testImportAllFilter2"));
    }

    /**
     * 正常系
     * 複数のクラスロード時に存在しないクラスが指定された場合、
     * 存在するクラスのみロードされること
     * @test
     */
    public function okLoadMultipleClassWithNotExistClass()
    {
        $classLoader = new ClassLoader();
        $list = $classLoader->load(["ClassLoaderTestClassStaticLoadMultiple3", "DummyClass"]);
        $instance = new \WebStream\Test\TestData\ClassLoaderTestClassStaticLoadMultiple3();
        $this->assertTrue($instance instanceof \WebStream\Test\TestData\ClassLoaderTestClassStaticLoadMultiple3);
        $this->assertTrue(count($list) === 1);
    }
}
