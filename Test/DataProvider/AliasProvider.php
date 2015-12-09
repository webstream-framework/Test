<?php
namespace WebStream\Test\DataProvider;

/**
 * AliasProvider
 * @author Ryuichi TANAKA.
 * @since 2015/12/09
 * @version 0.7
 */
trait AliasProvider
{
    public function aliasAccessProvider()
    {
        return [
            ["/test_alias_method1", "originMethod1"],
            ["/test_alias_method2", "originMethod2"],
            ["/test_alias_method3", "originMethod3"],
            ["/test_alias_method4", "originMethod4"]
        ];
    }

    public function originAccessProvider()
    {
        return [
            ["/test_alias_method5", "originMethod5"],
            ["/test_alias_method6", "originMethod6"],
            ["/test_alias_method7", "originMethod7"],
            ["/test_alias_method8", "originMethod8"]
        ];
    }
}
