<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * FilterProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/10
 * @version 0.7
 */
trait FilterProvider
{
    public function beforeAfterFilterProvider()
    {
        return [
            ["/test", "unit_test#before_and_after", "b1b2a1a2"]
        ];
    }

    public function exceptFilterProvider()
    {
        return [
            ["/test", "unit_test#before_except_enable", "beea"],
            ["/test", "unit_test#before_except_disable", "bbeda"],
            ["/test", "unit_test#after_except_enable", "baee"],
            ["/test", "unit_test#after_except_disable", "baeda"]
        ];
    }

    public function onlyFilterProvider()
    {
        return [
            ["/test", "unit_test#before_only_enable", "bboe"],
            ["/test", "unit_test#before_only_disable", "bod"],
            ["/test", "unit_test#after_only_enable", "aoea"],
            ["/test", "unit_test#after_only_disable", "aod"]
        ];
    }

    public function multipleExceptFilterProvider()
    {
        return [
            ["/test", "unit_test#before_except_enable", "beea"],
            ["/test", "unit_test#before_except_enable2", "bee2a"],
            ["/test", "unit_test#after_except_enable", "baee"],
            ["/test", "unit_test#after_except_enable2", "baee2"]
        ];
    }

    public function multipleOnlyFilterProvider()
    {
        return [
            ["/test", "unit_test#before_only_enable", "bboe"],
            ["/test", "unit_test#before_only_enable2", "bboe2"],
            ["/test", "unit_test#after_only_enable", "aoea"],
            ["/test", "unit_test#after_only_enable2", "aoe2a"]
        ];
    }

    public function skipFilterProvider()
    {
        return [
            ["/test", "unit_test#skip_enable", "seb2"],
            ["/test", "unit_test#multiple_skip_enable", "mse"]
        ];
    }

    public function exceptAndOnlyFilterProvider()
    {
        return [
            ["/test", "unit_test#action", "a"]
        ];
    }

    public function initializeFilterProvider()
    {
        return [
            ["/test", "unit_test#action", 500]
        ];
    }
}
