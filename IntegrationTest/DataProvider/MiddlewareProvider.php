<?php
namespace WebStream\Test\IntegrationTest\DataProvider;

/**
 * MiddlewareProvider
 * @author Ryuichi TANAKA.
 * @since 2016/07/16
 * @version 0.7
 */
trait MiddlewareProvider
{
    public function cacheProvider()
    {
        return [
            ["/middleware/cache/apcu", "12111"],
            ["/middleware/cache/memcached", "12111"],
            ["/middleware/cache/redis", "12111"]
        ];
    }
}
