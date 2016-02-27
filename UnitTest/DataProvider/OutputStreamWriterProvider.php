<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * OutputStreamWriterProvider
 * @author Ryuichi TANAKA.
 * @since 2016/02/26
 * @version 0.7
 */
trait OutputStreamWriterProvider
{
    public function charWriteProvider()
    {
        return [
            ["a"]
        ];
    }

    public function charWriteAppendProvider()
    {
        return [
            ["a", "b"]
        ];
    }

    public function charWriteOffsetProvider()
    {
        return [
            ["abcdefghijk", "defghijk", 3],
            ["あいうえお", "いうえお", 3]
        ];
    }

    public function charWriteOffsetLengthProvider()
    {
        return [
            ["abcdefghijk", "d", 3, 1],
            ["あいうえお", "い", 3, 3]
        ];
    }
}
