<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * InputStreamReaderProvider
 * @author Ryuichi TANAKA.
 * @since 2016/02/10
 * @version 0.7
 */
trait InputStreamReaderProvider
{
    public function charReadProvider()
    {
        return [
            ["a", 1],
            ["あ", 3]
        ];
    }

    public function overCharReadProvider()
    {
        return [
            ["abc", 100]
        ];
    }

    public function readLineProvider()
    {
        return [
            ["abc\nde", "abc", "de"],
            ["あい\nうえお", "あい", "うえお"]
        ];
    }

    public function skipProvider()
    {
        return [
            ["abcdefghi", 0, "a"],
            ["abcdefghi", 1, "b"],
            ["abcdefghi", 3, "d"],
            ["abcdefghi", 5, "f"],
            ["abcdefghi", 9, ""],
            ["abcdefghi", 10, ""]
        ];
    }

    public function overSkipAndReadProvider()
    {
        return [
            ["abc", 3]
        ];
    }

    public function overSkipAndReadLineProvider()
    {
        return [
            ["abcde\nあいうえお", 100]
        ];
    }

    public function readLineAndOverSkipReadProvider()
    {
        return [
            ["abcde"]
        ];
    }

    public function resetProvider()
    {
        return [
            ["a"]
        ];
    }

    public function overFrontSkipProvider()
    {
        return [
            ["a", -1],
            ["a", -100],
        ];
    }
}
