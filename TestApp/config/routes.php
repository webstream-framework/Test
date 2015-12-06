<?php
namespace WebStream\Delegate;

/**
 * ルーティングルールを記述する
 */
Router::setRule([
    '/' => "test#test1",
    '/top' => "test#test2",
    '/top/:id' => "test#test3",
    '/top/snake1/:snake_id' => "test#test4",
    '/top/snake2/:_snake_id' => "test#test5",
    '/placeholder_ng1/:1abc' => "test#placeholderNg",
    '/notfound/controller' => "notfound#test1",
    '/notfound/action' => "test#notfound",
    '/action' => "test#test_action",
    '/action2' => "test#test_action_hoge_fuga",
    '/feed.:format' => "test#test_feed",
    '/snake' => "test_snake#index",
    '/snake2' => "test_snake_hoge_fuga#index",
    '/encoded/:name' => "test#test_encoded",
    '/similar/:name' => "test#test_similar1",
    '/similar/:name/:page' => "test#test_similar2",
    '/snake_ng1' => "test__snake#index",
    '/snake_ng2' => "test_snake_#index",
    '/no_service' => "test_no_service_class#execute",
    '/no_service2' => "test_no_service_method#execute",
    '/no_service_no_model' => "test_no_service_and_model#execute",
    '/test_service1' => "test#service1",
    '/test_service2' => "test#service2",
    '/exist_service_exist_model_exist_model_method_param' => "test_exist_service_exist_model_exist_model_method#send_param",
    '/exist_service_exist_model_exist_model_method_params' => "test_exist_service_exist_model_exist_model_method#send_params",
    '/test_template/basic/index1' => "test_basic_template#index1",
    '/test_template/basic/index2' => "test_basic_template#index2",
    '/test_template/basic/index3' => "test_basic_template#index3",
    '/test_template/basic/index4' => "test_basic_template#index4",
    '/test_template/basic/index5' => "test_basic_template#index5",
    '/test_template/basic/index6' => "test_basic_template#index6",
    '/test_template/basic/index7' => "test_basic_template#index7",
    '/test_template/basic/index8' => "test_basic_template#index8",
    '/test_template/basic/index9' => "test_basic_template#index9",
    '/test_template/basic/index10' => "test_basic_template#index10",
    '/test_template/basic/index11' => "test_basic_template#index11",
    '/test_template/basic/index12' => "test_basic_template_without_helper#index1",
    '/test_template/basic/index13' => "test_basic_template_without_model#index1",
    '/test_template/basic/index14' => "test_basic_template_with_helper#index1",
    '/test_template/basic/index15' => "test_basic_template_with_service#index1",
    '/test_template/basic/index16' => "test_basic_template_with_model#index1",
    '/test_template/basic/index17' => "test_basic_template#index12",
    '/test_template/basic/index18' => "test_basic_template_with_helper#index2",
    '/test_template/basic/index19' => "test_basic_template_with_helper#index3",
    '/test_template/basic/error1' => "test_basic_template#error1",
    '/test_template/basic/error2' => "test_basic_template#error2",
    '/test_template/basic/error3' => "test_basic_template#error3",
    '/test_template/basic/error4' => "test_basic_template#error4",
    '/test_template/basic/error5' => "test_basic_template#error5",
    '/test_template/basic/error6' => "test_basic_template#error6",
    '/test_template/basic/error7' => "test_basic_template#error7",
    '/test_template/basic/error8' => "test_basic_template#error8",
    '/test_template/basic/error9' => "test_basic_template_without_helper#error1",
    '/test_template/basic/error10' => "test_basic_template_without_model#error1",
    '/test_template/basic/html1' => "test_basic_template#html1",
    '/test_template/basic/html2' => "test_basic_template#html2",
    '/test_template/basic/xml' => "test_basic_template#xml",
    '/test_template/basic/javascript1' => "test_basic_template#javascript1",
    '/test_template/basic/javascript2' => "test_basic_template#javascript2",
    '/test_template/basic/javascript3' => "test_basic_template#javascript3",
    '/test_template/basic/javascript4' => "test_basic_template#javascript4",
    '/test_template/basic/javascript5' => "test_basic_template#javascript5",
    '/test_template/basic/javascript6' => "test_basic_template#javascript6",
    '/test_template/basic/javascript7' => "test_basic_template#javascript7",
    '/test_template/basic/javascript8' => "test_basic_template#javascript8",
    '/test_template/twig/index1' => "test_twig_template#index1",
    '/test_template/twig/index2' => "test_twig_template#index2",
    '/test_template/twig/index3' => "test_twig_template#index3",
    '/test_template/twig/index4' => "test_twig_template#index4",
    '/test_template/twig/index5' => "test_twig_template#index5",
    '/test_template/twig/index6' => "test_twig_template#index6",
    '/test_template/twig/error1' => "test_twig_template#error1",
    '/csrf' => "test_security#test_csrf",
    '/csrf_get' => "test_security#test_csrf_get",
    '/csrf_post' => "test_security#test_csrf_post",
    '/csrf_post_view' => "test_security#test_csrf_post_view",
    '/csrf_helper' => "test_security#test_csrf_helper",
    '/test_header/html' => "test_header#test1",
    '/test_header/xml' => "test_header#test2",
    '/test_header/atom' => "test_header#test3",
    '/test_header/rss' => "test_header#test4",
    '/test_header/rdf' => "test_header#test5",
    '/test_header/get1' => "test_header#test6",
    '/test_header/get2' => "test_header#test7",
    '/test_header/post1' => "test_header#test8",
    '/test_header/post2' => "test_header#test9",
    '/test_header/get_or_post' => "test_header#test10",
    '/test_header/post_or_put' => "test_header#test11",
    '/test_header/html_get' => "test_header#test12",
    '/test_header/xml_post' => "test_header#test13",
    '/test_header/dummy_contenttype' => "test_header#test14",
    '/test_header/dummy_allowmethod' => "test_header#test15",
    '/test_header/parent/html' => "test_header#test16",
    '/exception_handler1' => "test_exception_handler#index1",
    '/exception_handler2' => "test_exception_handler#index2",
    '/exception_handler3' => "test_exception_handler#index3",
    '/exception_handler4' => "test_exception_handler#index4",
    '/exception_handler5' => "test_exception_handler#index5",
    '/exception_handler6' => "test_exception_handler#index6",
    '/exception_handler7' => "test_exception_handler#error1",
    '/exception_handler8' => "test_exception_handler#error2",
    '/exception_handler9' => "test_exception_handler#error3",
    '/exception_handler10' => "test_exception_handler#error4",
    '/exception_handler11' => "test_exception_handler#error5",
    '/multiple_exception_handler1' => "test_multiple_exception_handler#index1",
    '/multiple_exception_handler2' => "test_sub_multiple_exception_handler#index1",
    '/multiple_exception_handler3' => "test_multiple_exception_handler#index2",
    '/multiple_exception_handler4' => "test_multiple_exception_handler#index3",
    '/multiple_exception_handler5' => "test_multiple_exception_handler#index4",
    '/multiple_exception_handler6' => "test_multiple_exception_handler#index5",
    '/double_exception_handler1' => "test_double_exception_handler#index1",
    '/double_exception_handler2' => "test_double_exception_handler#index2",
    '/parent_exception_handler1' => "test_exception_handler_child#index1",
    '/parent_exception_handler2' => "test_exception_handler_child#index2",
    '/session_limit' => "test_session#set_session_limit_expire",
    '/session_no_limit' => "test_session#set_session_no_limit_expire",
    '/session_index' => "test_session#index1",
    '/before_after_filter' => "test_filter#index",
    '/before_after_multiple_filter' => "test_multiple_filter#index",
    '/before_after_override_filter' => "test_override_filter#index",
    '/initialize_filter_error' => "test_initialize_filter#index",
    '/invalid_filter_error' => "test_invalid_filter#index",
    '/before_filter_except_enable' => "test_except_filter#index",
    '/before_filter_except_disable' => "test_except_filter#index2",
    '/after_filter_except_enable' => "test_except_filter#index3",
    '/after_filter_except_disable' => "test_except_filter#index4",
    '/before_filter_only_enable' => "test_only_filter#index",
    '/before_filter_only_disable' => "test_only_filter#index2",
    '/after_filter_only_enable' => "test_only_filter#index3",
    '/after_filter_only_disable' => "test_only_filter#index4",
    '/before_filter_multiple_except_enable' => "test_multiple_except_filter#index",
    '/before_filter_multiple_except_enable2' => "test_multiple_except_filter#index2",
    '/after_filter_multiple_except_enable' => "test_multiple_except_filter#index3",
    '/after_filter_multiple_except_enable2' => "test_multiple_except_filter#index4",
    '/before_filter_multiple_only_enable' => "test_multiple_only_filter#index",
    '/before_filter_multiple_only_enable2' => "test_multiple_only_filter#index2",
    '/after_filter_multiple_only_enable' => "test_multiple_only_filter#index3",
    '/after_filter_multiple_only_enable2' => "test_multiple_only_filter#index4",
    '/filter_except_only' => "test_except_only_filter#index",
    '/skip_filter1' => "test_skip_filter#index1",
    '/skip_filter2' => "test_skip_filter#index2",
    '/test_helper1' => "test_helper#help1",
    '/test_helper2' => "test_helper#help2",
    '/test_helper3' => "test_helper#help3",
    '/test_helper4' => "test_helper#help4",
    '/test_helper5' => "test_helper#help5",
    '/test_helper6' => "test_helper#help6",
    '/test_model1' => "test_mysql#model1",
    '/test_model2' => "test_mysql#model2",
    '/test_model3' => "test_mysql#model3",
    '/test_model4' => "test_sqlite#model1",
    '/test_model5' => "test_sqlite#model2",
    '/test_model6' => "test_mysql#model5",
    '/test_model7' => "test_mysql#model4",
    '/test_model8' => "test_database_error1#model1",
    '/test_model9' => "test_database_error2#model1",
    '/test_model10' => "test_mysql#model6",
    '/test_model11' => "test_database_error3#model1",
    '/test_model12' => "test_postgres#model1",
    '/test_model13' => "test_postgres#model2",
    '/test_model14' => "test_postgres#model3",
    '/test_model15' => "test_postgres#model4",
    '/test_model16' => "test_postgres#model5",
    '/test_model17' => "test_postgres#model6",
    '/test_model18' => "test_sqlite#model3",
    '/test_model19' => "test_mysql#model7",
    '/test_model20' => "test_postgres#model7",
    '/test_model21' => "test_sqlite#model4",
    '/test_model22' => "test_multiple_database#model1",
    '/test_model23' => "test_mysql_yml#model1",
    '/test_model24' => "test_mysql_yaml#model1",
    '/test_model25' => "test_mysql#model8",
    '/test_model26' => "test_postgres#model8",
    '/test_model27' => "test_sqlite#model5",
    '/test_model28' => "test_mysql#model9",
    '/test_model29' => "test_postgres#model9",
    '/test_model30' => "test_sqlite#model6",
    '/test_model31' => "test_mysql#model10",
    '/test_model32' => "test_postgres#model10",
    '/test_model33' => "test_sqlite#model7",
    '/test_model34' => "test_mysql#model11",
    '/test_model35' => "test_postgres#model11",
    '/test_model36' => "test_sqlite#model8",
    '/test_model37' => "test_mysql#model12",
    '/test_model38' => "test_postgres#model12",
    '/test_model39' => "test_sqlite#model9",
    '/test_model40' => "test_mysql#model13",
    '/test_model41' => "test_postgres#model13",
    '/test_model42' => "test_sqlite#model10",
    '/test_model43' => "test_database_error3#model2",
    '/test_model44' => "test_mysql#model14",
    '/test_model45' => "test_postgres#model14",
    '/test_model46' => "test_sqlite#model11",
    '/test_model47' => "test_mysql#model15",
    '/test_model48' => "test_postgres#model15",
    '/test_model49' => "test_sqlite#model12",
    '/test_model50' => "test_database_error4#model1",
    '/test_transaction1' => "test_transaction#transaction_in_controller",
    '/test_transaction2' => "test_transaction#transaction_rollback_in_controller",
    '/test_transaction3' => "test_transaction#transaction_in_model",
    '/test_transaction_clear' => "test_transaction#clear",
    '/test_model_prepare' => "test_mysql#prepare",
    '/test_model_clear' => "test_mysql#clear",
    '/test_model_prepare2' => "test_postgres#prepare",
    '/test_model_clear2' => "test_postgres#clear",
    '/test_model_prepare3' => "test_sqlite#prepare",
    '/test_model_clear3' => "test_sqlite#clear",
    '/test_model_prepare4' => "test_mysql_yml#prepare",
    '/test_model_clear4' => "test_mysql_yml#clear",
    '/test_model_prepare5' => "test_mysql#prepare2",
    '/test_model_clear5' => "test_mysql#clear2",
    '/test_model_prepare6' => "test_postgres#prepare2",
    '/test_model_clear6' => "test_postgres#clear2",
    '/test_model_prepare7' => "test_sqlite#prepare2",
    '/test_model_clear7' => "test_sqlite#clear2",
    '/test_model_prepare8' => "test_mysql#prepare3",
    '/test_model_clear8' => "test_mysql#clear3",
    '/test_model_prepare9' => "test_postgres#prepare3",
    '/test_model_clear9' => "test_postgres#clear3",
    '/test_model_prepare10' => "test_sqlite#prepare3",
    '/test_model_clear10' => "test_sqlite#clear3",
    '/test_template/xml' => "test_template#xml",
    '/test_json1' => "test_json#json1",
    '/test_json2' => "test_json#json2",
    '/test_jsonp1' => "test_json#jsonp1",
    '/test_jsonp2' => "test_json#jsonp2",
    '/test_iterator1' => "test_iterator#count",
    '/test_iterator2' => "test_iterator#seek",
    '/test_iterator3' => "test_iterator#seek_failure",
    '/test_iterator4' => "test_iterator#key_value",
    '/test_iterator5' => "test_iterator#array_access_get",
    '/test_iterator6' => "test_iterator#array_access_set",
    '/test_custom_dir1' => "test_custom_dir#from_controller",
    '/test_custom_dir2' => "test_custom_dir#from_service",
    '/test_custom_dir3' => "test_custom_dir#from_model",
    '/test_custom_dir4' => "test_custom_dir#from_view",
    '/test_custom_dir5' => "test_custom_dir#from_helper",
    '/test_helper_async' => "test_helper#help7",
    '/test_helper_multiple_async' => "test_helper#help8",
    '/test_helper_async_response' => "test_helper#help7_async",
    '/test_helper_async_response2' => "test_helper#help8_async2",
    '/test_helper_async_response3' => "test_helper#help8_async3",
    '/test_custom_class_annotation/index1' => "test_custom_class1_annotation#index1",
    '/test_custom_class_annotation/index2' => "test_custom_class2_annotation#index1",
    '/test_custom_class_annotation/service1' => "test_custom_class1_annotation#index2",
    '/test_custom_class_annotation/service2' => "test_custom_class2_annotation#index2",
    '/test_custom_class_annotation/model1' => "test_custom_class1_annotation#index3",
    '/test_custom_class_annotation/model2' => "test_custom_class2_annotation#index3",
    '/test_custom_method_annotation/index1' => "test_custom_method_annotation#index1",
    '/test_custom_method_annotation/index2' => "test_custom_method_annotation#index2",
    '/test_custom_method_annotation/index3' => "test_custom_method_annotation#index3",
    '/test_custom_method_annotation/index4' => "test_custom_methods_annotation#index1",
    '/test_custom_method_annotation/service1' => "test_custom_method_annotation#index4",
    '/test_custom_method_annotation/service2' => "test_custom_method_annotation#index5",
    '/test_custom_method_annotation/service3' => "test_custom_method_annotation#index6",
    '/test_custom_method_annotation/service4' => "test_custom_methods_annotation#index2",
    '/test_custom_method_annotation/model1' => "test_custom_method_annotation#index7",
    '/test_custom_method_annotation/model2' => "test_custom_method_annotation#index8",
    '/test_custom_method_annotation/model3' => "test_custom_method_annotation#index9",
    '/test_custom_method_annotation/model4' => "test_custom_methods_annotation#index3",
    '/test_custom_property_annotation/index1' => "test_custom_property1_annotation#index1",
    '/test_custom_property_annotation/index2' => "test_custom_property2_annotation#index1",
    '/test_custom_property_annotation/index3' => "test_custom_property3_annotation#index1",
    '/test_autowired/index' => "test_autowired#index1",
    '/test_autowired/service' => "test_autowired#index2",
    '/test_autowired/model' => "test_autowired#index3",
    '/test_autowired/helper' => "test_autowired#index4",
    '/test_validate/required/get' => "test_validate#get_required",
    '/test_validate/required/post' => "test_validate#post_required",
    '/test_validate/required/put' => "test_validate#put_required",
    '/test_validate/required/all' => "test_validate#all_required",
    '/test_validate/equal/get' => "test_validate#get_equal",
    '/test_validate/equal/post' => "test_validate#post_equal",
    '/test_validate/equal/put' => "test_validate#put_equal",
    '/test_validate/equal/all' => "test_validate#all_equal",
    '/test_validate/length/get' => "test_validate#get_length",
    '/test_validate/length/post' => "test_validate#post_length",
    '/test_validate/length/put' => "test_validate#put_length",
    '/test_validate/length/all' => "test_validate#all_length",
    '/test_validate/max/get' => "test_validate#get_max",
    '/test_validate/max/post' => "test_validate#post_max",
    '/test_validate/max/put' => "test_validate#put_max",
    '/test_validate/max/all' => "test_validate#all_max",
    '/test_validate/min/get' => "test_validate#get_min",
    '/test_validate/min/post' => "test_validate#post_min",
    '/test_validate/min/put' => "test_validate#put_min",
    '/test_validate/min/all' => "test_validate#all_min",
    '/test_validate/max_length/get' => "test_validate#get_max_length",
    '/test_validate/max_length/post' => "test_validate#post_max_length",
    '/test_validate/max_length/put' => "test_validate#put_max_length",
    '/test_validate/max_length/all' => "test_validate#all_max_length",
    '/test_validate/min_length/get' => "test_validate#get_min_length",
    '/test_validate/min_length/post' => "test_validate#post_min_length",
    '/test_validate/min_length/put' => "test_validate#put_min_length",
    '/test_validate/min_length/all' => "test_validate#all_min_length",
    '/test_validate/number/get' => "test_validate#get_number",
    '/test_validate/number/post' => "test_validate#post_number",
    '/test_validate/number/put' => "test_validate#put_number",
    '/test_validate/number/all' => "test_validate#all_number",
    '/test_validate/range/get' => "test_validate#get_range",
    '/test_validate/range/post' => "test_validate#post_range",
    '/test_validate/range/put' => "test_validate#put_range",
    '/test_validate/range/all' => "test_validate#all_range",
    '/test_validate/regexp/get' => "test_validate#get_regexp",
    '/test_validate/regexp/post' => "test_validate#post_regexp",
    '/test_validate/regexp/put' => "test_validate#put_regexp",
    '/test_validate/regexp/all' => "test_validate#all_regexp",
    '/test_validate/invalid_rule/unknown' => "test_validate#invalid_rule_unknown",
    '/test_validate/invalid_rule/required' => "test_validate#invalid_rule_required",
    '/test_validate/invalid_rule/equal' => "test_validate#invalid_rule_equal",
    '/test_validate/invalid_rule/length1' => "test_validate#invalid_rule_length1",
    '/test_validate/invalid_rule/length2' => "test_validate#invalid_rule_length2",
    '/test_validate/invalid_rule/length3' => "test_validate#invalid_rule_length3",
    '/test_validate/invalid_rule/max' => "test_validate#invalid_rule_max",
    '/test_validate/invalid_rule/min' => "test_validate#invalid_rule_min",
    '/test_validate/invalid_rule/max_length' => "test_validate#invalid_rule_max_length",
    '/test_validate/invalid_rule/min_length' => "test_validate#invalid_rule_min_length",
    '/test_validate/invalid_rule/number' => "test_validate#invalid_rule_number",
    '/test_validate/invalid_rule/range1' => "test_validate#invalid_rule_range1",
    '/test_validate/invalid_rule/range2' => "test_validate#invalid_rule_range2",
    '/test_validate/invalid_rule/regexp' => "test_validate#invalid_rule_regexp",
    '/test_validate/invalid_annotation1' => "test_validate#invalid_validate_annotation2",
    '/test_validate/invalid_annotation2' => "test_validate#invalid_validate_annotation2",
    '/test_validate/custom/mail/get' => "test_validate#get_mail",
    '/test_validate/custom/mail/post' => "test_validate#post_mail",
    '/test_validate/custom/mail/put' => "test_validate#put_mail",
    '/test_validate/custom/mail/all' => "test_validate#all_mail",
    '/test_validate/custom/invalid/get' => "test_validate#duplicate_validate_rule",
    '/test_view_model_in_service/service1' => "test_view_model_in_service#service1",
    '/test_view_model_in_service/service2' => "test_view_model_in_service#service2",
    '/test_view_model_in_model/model1' => "test_view_model_in_model#model1",
    '/test_view_model_in_model/model2' => "test_view_model_in_model#model2",
    '/test_logger_adapter1' => "test_logger_adapter#controller_test",
    '/test_logger_adapter2' => "test_logger_adapter#service_test",
    '/test_logger_adapter3' => "test_logger_adapter#model_test",
    '/test_logger_adapter4' => "test_logger_adapter#helper_test"
]);
