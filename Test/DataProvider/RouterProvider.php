<?php
namespace WebStream\Test\DataProvider;

/**
 * RouterProvider
 * @author Ryuichi TANAKA.
 * @since 2013/09/21
 * @version 0.4
 */
trait RouterProvider
{
    // 正常系
    public function resolvePathWithoutPlaceHolderProvider()
    {
        return [
            ["/", "test1"],
            ["/top", "test2"]
        ];
    }

    public function resolvePathWithPlaceHolderProvider()
    {
        return [
            ['/top/:id', "test3"],
            ['/top/snake1/:snake_id', "test4"],
            ['/top/:_snake_id', "test5"]
        ];
    }

    public function resolveCamelActionProvider()
    {
        return [
            ['/action', "testAction"],
            ['/action2', "testAction2"]
        ];
    }

    public function resolveWithPlaceHolderFormatProvider()
    {
        return [
            ['/feed.rss']
        ];
    }

    public function snakeControllerProvider()
    {
        return [
            ["/snake", "snake"],
            ["/snake2", "snake2"]
        ];
    }

    public function uriWithEncodedStringProvider()
    {
        return [
            ['/encoded/%E3%81%A6%E3%81%99%E3%81%A8', 'てすと']
        ];
    }

    public function resolveSimilarUrlProvider()
    {
        return [
            ["/similar/name", "similar1"],
            ["/similar/name/2", "similar2"]
        ];
    }

    public function readStaticFileProvider()
    {
        return [
            ['/css/sample.css', "text/css"],
            ['/css/sample2.CSS', "text/css"],
            ['/js/sample.js', "text/javascript"],
            ['/js/sample2.JS', "text/javascript"],
            ['/img/sample.png', "image/png"],
            ['/img/sample2.PNG', "image/png"]
        ];
    }

    public function downloadStaticFile()
    {
        return [
            ['/file/sample.atom', "application/atom+xml"],
            ['/file/sample.htm', "text/html"],
            ['/file/sample.html', "text/html"],
            ['/file/sample.json', "application/json"],
            ['/file/sample.pdf', "application/pdf"],
            ['/file/sample.php', "application/octet-stream"],
            ['/file/sample.rdf', "application/rdf+xml"],
            ['/file/sample.txt', "text/plain"],
            ['/file/sample.xml', "application/xml"],
            ['/file/sample.csv', "text/csv"],
            ['/file/sample.tsv', "text/tab-separated-values"]
        ];
    }

    public function readCustomStaticFile()
    {
        return [
            ['/custom/sample.txt', "text/plain"]
        ];
    }

    public function customDirProvider()
    {
        return [
            ['/test_custom_dir1', 'WebStream\Test\TestData\Sample\App\Entity\TestEntity'],
            ['/test_custom_dir2', 'WebStream\Test\TestData\Sample\App\Entity\TestEntity'],
            ['/test_custom_dir3', 'WebStream\Test\TestData\Sample\App\Entity\TestEntity'],
            ['/test_custom_dir4', 'WebStream\Test\TestData\Sample\App\Entity\TestEntity'],
            ['/test_custom_dir5', 'WebStream\Test\TestData\Sample\App\Entity\TestEntity']
        ];
    }

    public function compileLessProvider()
    {
        return [
            ['/css/sample_less.css', '/core/WebStream/Test/Sample/app/views/_public/css/sample_less.css']
        ];
    }

    // 異常系
    public function resolveUnknownProvider()
    {
        return [
            ['/notfound/controller', "notfound#test"],
            ['/notfound/action', "test#notfound"]
        ];
    }

    public function multipleSnakeControllerProvider()
    {
        return [
            ["/snake_ng1"],
            ["/snake_ng2"]
        ];
    }

    public function placeHolderInitialCharIsNumberProvider()
    {
        return [
            ["/placeholder_ng1/1"]
        ];
    }
}
