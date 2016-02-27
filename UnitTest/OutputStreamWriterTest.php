<?php
namespace WebStream\Test\UnitTest;

use WebStream\IO\ConsoleOutputStream;
use WebStream\IO\Writer\OutputStreamWriter;
use WebStream\Test\UnitTest\DataProvider\OutputStreamWriterProvider;

require_once dirname(__FILE__) . '/TestBase.php';
require_once dirname(__FILE__) . '/DataProvider/OutputStreamWriterProvider.php';

/**
 * OutputStreamWriterTest
 * @author Ryuichi TANAKA.
 * @since 2016/02/26
 * @version 0.7
 */
class OutputStreamWriterTest extends \PHPUnit_Framework_TestCase
{
    use OutputStreamWriterProvider;

    /**
     * 正常系
     * 文字列を書き込めること
     * @test
     * @dataProvider charWriteProvider
     */
    public function okCharWrite($str)
    {
        $cos = new ConsoleOutputStream();
        $osw = new OutputStreamWriter($cos);
        $osw->write($str);
        $this->expectOutputString($str);
        $osw->flush();
        $osw->close();
    }

    /**
     * 正常系
     * 複数の文字列を書き込めること
     * @test
     * @dataProvider charWriteAppendProvider
     */
    public function okCharWriteAppend($str1, $str2)
    {
        $cos = new ConsoleOutputStream();
        $osw = new OutputStreamWriter($cos);
        $osw->write($str1);
        $osw->write($str2);
        $this->expectOutputString($str1 . $str2);
        $osw->flush();
        $osw->close();
    }

    /**
     * 正常系
     * offset指定で文字列を書き込めること
     * @test
     * @dataProvider charWriteOffsetProvider
     */
    public function okCharWriteOffset($inStr, $outStr, $offset)
    {
        $cos = new ConsoleOutputStream();
        $osw = new OutputStreamWriter($cos);
        $osw->write($inStr, $offset);
        $this->expectOutputString($outStr);
        $osw->flush();
        $osw->close();
    }

    /**
     * 正常系
     * offset,length指定で文字列を書き込めること
     * @test
     * @dataProvider charWriteOffsetLengthProvider
     */
    public function okCharWriteOffsetLength($inStr, $outStr, $offset, $length)
    {
        $cos = new ConsoleOutputStream();
        $osw = new OutputStreamWriter($cos);
        $osw->write($inStr, $offset, $length);
        $this->expectOutputString($outStr);
        $osw->flush();
        $osw->close();
    }
}
