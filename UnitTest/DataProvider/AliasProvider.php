<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * AliasProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/11
 * @version 0.7
 */
trait AliasProvider
{
    public function aliasAccessProvider()
    {
        return [
            ["/test", "unit_test#alias_method1", "originMethod1"],
            ["/test", "unit_test#alias_method2", "originMethod2"],
            ["/test", "unit_test#alias_method3", "originMethod3"]
        ];
    }

    public function originAccessProvider()
    {
        return [
            ["/test", "unit_test#alias_method1", "originMethod1"],
            ["/test", "unit_test#alias_method2", "originMethod2"],
            ["/test", "unit_test#alias_method3", "originMethod3"]
        ];
    }

    public function aliasAccessErrorProvider()
    {
        return [
            ["/test", "unit_test#origin_method1"],
            ["/test", "unit_test#origin_method2"],
            ["/test", "unit_test#origin_method3"]
        ];
    }
}
