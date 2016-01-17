<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * HeaderProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/17
 * @version 0.7
 */
trait HeaderProvider
{
    public function runDisplayHeaderProvider()
    {
        return [
            ["file.txt", "text/plain"],
            ["file.jpg", "image/jpeg"],
            ["file.jpeg", "image/jpeg"],
            ["file.gif", "image/gif"],
            ["file.png", "image/png"],
            ["file.tiff", "image/tiff"],
            ["file.tif", "image/tiff"],
            ["file.bmp", "image/bmp"],
            ["file.ico", "image/x-icon"],
            ["file.svg", "image/svg+xml"],
            ["file.xml", "application/xml"],
            ["file.xsl", "application/xml"],
            ["file.rss", "application/rss+xml"],
            ["file.rdf", "application/rdf+xml"],
            ["file.atom", "application/atom+xml"],
            ["file.zip", "application/zip"],
            ["file.html", "text/html"],
            ["file.htm", "text/html"],
            ["file.css", "text/css"],
            ["file.csv", "text/csv"],
            ["file.tsv", "text/tab-separated-values"],
            ["file.js", "text/javascript"],
            ["file.jsonp", "text/javascript"],
            ["file.json", "application/json"],
            ["file.pdf", "application/pdf"],
            ["file.undefined", "application/octet-stream"]
        ];
    }

    public function runAllowMethodProvider()
    {
        return [
            ["/test", "unit_test#allow_get1", "GET", "g"],
            ["/test", "unit_test#allow_get2", "GET", "g"],
            ["/test", "unit_test#allow_post1", "POST", "p"],
            ["/test", "unit_test#allow_post2", "POST", "p"],
            ["/test", "unit_test#allow_get_post", "GET", "gp"],
            ["/test", "unit_test#allow_get_post", "POST", "gp"]
        ];
    }

    public function runContentTypeAndAllowMethodProvider()
    {
        return [
            ["file.xml", "application/xml", "POST"]
        ];
    }

    public function runNotAllowMethodProvider()
    {
        return [
            ["/test", "unit_test#allow_get1", "POST", 405],
            ["/test", "unit_test#allow_get2", "POST", 405],
            ["/test", "unit_test#allow_post1", "GET", 405],
            ["/test", "unit_test#allow_post2", "GET", 405],
            ["/test", "unit_test#allow_get_post", "PUT", 405]
        ];
    }
}
