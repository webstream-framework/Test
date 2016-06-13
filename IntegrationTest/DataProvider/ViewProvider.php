<?php
namespace WebStream\Test\IntegrationTest\DataProvider;

/**
 * ViewProvider
 * @author Ryuichi TANAKA.
 * @since 2016/06/10
 * @version 0.7
 */
trait ViewProvider
{
    public function viewAccessProvider()
    {
        return [
            ["/view/basic", "basic"],
            ["/view/basic/parts", "basic_parts"],
            ["/view/twig", "twig"]
        ];
    }
}
