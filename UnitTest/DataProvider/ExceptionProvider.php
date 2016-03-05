<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ExceptionProvider
 * @author Ryuichi TANAKA.
 * @since 2016/03/05
 * @version 0.7
 */
trait ExceptionProvider
{
    public function exceptionProvider()
    {
        return [
            ["WebStream\Exception\Extend\AnnotationException"],
            ["WebStream\Exception\Extend\ClassNotFoundException"],
            ["WebStream\Exception\Extend\CollectionException"],
            ["WebStream\Exception\Extend\CsrfException"],
            ["WebStream\Exception\Extend\DatabaseException"],
            ["WebStream\Exception\Extend\ForbiddenAccessException"],
            ["WebStream\Exception\Extend\InvalidArgumentException"],
            ["WebStream\Exception\Extend\InvalidRequestException"],
            ["WebStream\Exception\Extend\IOException"],
            ["WebStream\Exception\Extend\LoggerException"],
            ["WebStream\Exception\Extend\MethodNotFoundException"],
            ["WebStream\Exception\Extend\OutOfBoundsException"],
            ["WebStream\Exception\Extend\ResourceNotFoundException"],
            ["WebStream\Exception\Extend\RouterException"],
            ["WebStream\Exception\Extend\SessionTimeoutException"],
            ["WebStream\Exception\ApplicationException"],
            ["WebStream\Exception\SystemException"]
        ];
    }
}
