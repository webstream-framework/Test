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
            ["/view/basic/encode/html", "&lt;p&gt;a&lt;/p&gt;"],
            ["/view/basic/encode/javascript", '\x3cscript\x3ealert(\u0022a\u0022);\x3c\/script\x3e'],
            ["/view/basic/encode/xml", "<item>&lt;test&gt;a&lt;/test&gt;</item>"],
            ["/view/basic/template_in_helper", "parts.tmplbasic_parts"]
        ];
    }

    public function viewNotAccessProvider()
    {
        return [
            ["/view/error/service_class_noexist_and_model_class_noexist", "TestNoServiceClassNoModelClassInViewService and TestNoServiceClassNoModelClassInViewModel is not defined."]
        ];
    }
}
