<?php
namespace WebStream\Test\UnitTest\DataProvider;

/**
 * ValidateProvider
 * @author Ryuichi TANAKA.
 * @since 2016/01/20
 * @version 0.7
 */
trait ValidateProvider
{
    public function validateProvider()
    {
        return [
            ["/test", "unit_test#get_required", "get", "test", "yryr"],
            ["/test", "unit_test#post_required", "post", "test", "yryr"],
            ["/test", "unit_test#put_required", "put", "test", "yryr"],
            ["/test", "unit_test#delete_required", "delete", "test", "yryr"],
            ["/test", "unit_test#all_required", "get", "test", "yryr"],
            ["/test", "unit_test#all_required", "post", "test", "yryr"],
            ["/test", "unit_test#all_required", "put", "test", "yryr"],
            ["/test", "unit_test#all_required", "delete", "test", "yryr"],
            ["/test", "unit_test#get_equal", "get", "test", "yryr"],
            ["/test", "unit_test#post_equal", "post", "test", "yryr"],
            ["/test", "unit_test#put_equal", "put", "test", "yryr"],
            ["/test", "unit_test#delete_equal", "delete", "test", "yryr"],
            ["/test", "unit_test#all_equal", "get", "test", "yryr"],
            ["/test", "unit_test#all_equal", "post", "test", "yryr"],
            ["/test", "unit_test#all_equal", "put", "test", "yryr"],
            ["/test", "unit_test#all_equal", "delete", "test", "yryr"],
            ["/test", "unit_test#get_length", "get", "test", "yryr"],
            ["/test", "unit_test#post_length", "post", "test", "yryr"],
            ["/test", "unit_test#put_length", "put", "test", "yryr"],
            ["/test", "unit_test#delete_length", "delete", "test", "yryr"],
            ["/test", "unit_test#all_length", "get", "test", "yryr"],
            ["/test", "unit_test#all_length", "post", "test", "yryr"],
            ["/test", "unit_test#all_length", "put", "test", "yryr"],
            ["/test", "unit_test#all_length", "delete", "test", "yryr"],
            ["/test", "unit_test#get_max", "get", "test", "3"],
            ["/test", "unit_test#post_max", "post", "test", "3"],
            ["/test", "unit_test#put_max", "put", "test", "3"],
            ["/test", "unit_test#delete_max", "delete", "test", "3"],
            ["/test", "unit_test#all_max", "get", "test", "3"],
            ["/test", "unit_test#all_max", "post", "test", "3"],
            ["/test", "unit_test#all_max", "put", "test", "3"],
            ["/test", "unit_test#all_max", "delete", "test", "3"],
            ["/test", "unit_test#get_min", "get", "test", "1"],
            ["/test", "unit_test#post_min", "post", "test", "1"],
            ["/test", "unit_test#put_min", "put", "test", "1"],
            ["/test", "unit_test#delete_min", "delete", "test", "1"],
            ["/test", "unit_test#all_min", "get", "test", "1"],
            ["/test", "unit_test#all_min", "post", "test", "1"],
            ["/test", "unit_test#all_min", "put", "test", "1"],
            ["/test", "unit_test#all_min", "delete", "test", "1"],
            ["/test", "unit_test#get_max_length", "get", "test", "yryr"],
            ["/test", "unit_test#post_max_length", "post", "test", "yryr"],
            ["/test", "unit_test#put_max_length", "put", "test", "yryr"],
            ["/test", "unit_test#delete_max_length", "delete", "test", "yryr"],
            ["/test", "unit_test#all_max_length", "get", "test", "yryr"],
            ["/test", "unit_test#all_max_length", "post", "test", "yryr"],
            ["/test", "unit_test#all_max_length", "put", "test", "yryr"],
            ["/test", "unit_test#all_max_length", "delete", "test", "yryr"],
            ["/test", "unit_test#get_min_length", "get", "test", "yuruyuri"],
            ["/test", "unit_test#post_min_length", "post", "test", "yuruyuri"],
            ["/test", "unit_test#put_min_length", "put", "test", "yuruyuri"],
            ["/test", "unit_test#delete_min_length", "delete", "test", "yuruyuri"],
            ["/test", "unit_test#all_min_length", "get", "test", "yuruyuri"],
            ["/test", "unit_test#all_min_length", "post", "test", "yuruyuri"],
            ["/test", "unit_test#all_min_length", "put", "test", "yuruyuri"],
            ["/test", "unit_test#all_min_length", "delete", "test", "yuruyuri"],
            ["/test", "unit_test#get_number", "get", "test", "1"],
            ["/test", "unit_test#post_number", "post", "test", "1"],
            ["/test", "unit_test#put_number", "put", "test", "1"],
            ["/test", "unit_test#delete_number", "delete", "test", "1"],
            ["/test", "unit_test#all_number", "get", "test", "1"],
            ["/test", "unit_test#all_number", "post", "test", "1"],
            ["/test", "unit_test#all_number", "put", "test", "1"],
            ["/test", "unit_test#all_number", "delete", "test", "1"],
            ["/test", "unit_test#get_range", "get", "test", "1"],
            ["/test", "unit_test#post_range", "post", "test", "1"],
            ["/test", "unit_test#put_range", "put", "test", "1"],
            ["/test", "unit_test#delete_range", "delete", "test", "1"],
            ["/test", "unit_test#all_range", "get", "test", "1"],
            ["/test", "unit_test#all_range", "post", "test", "1"],
            ["/test", "unit_test#all_range", "put", "test", "1"],
            ["/test", "unit_test#all_range", "delete", "test", "1"],
            ["/test", "unit_test#get_regexp", "get", "test", "1"],
            ["/test", "unit_test#post_regexp", "post", "test", "1"],
            ["/test", "unit_test#put_regexp", "put", "test", "1"],
            ["/test", "unit_test#delete_regexp", "delete", "test", "1"],
            ["/test", "unit_test#all_regexp", "get", "test", "1"],
            ["/test", "unit_test#all_regexp", "post", "test", "1"],
            ["/test", "unit_test#all_regexp", "put", "test", "1"],
            ["/test", "unit_test#all_regexp", "delete", "test", "1"]
        ];
    }

    public function validateErrorProvider()
    {
        return [
            ["/test", "unit_test#get_required", "get", "dummy", "dummy"],
            ["/test", "unit_test#get_required", "post", "test", "dummy"],
            ["/test", "unit_test#get_required", "put", "test", "dummy"],
            ["/test", "unit_test#get_required", "delete", "test", "dummy"],
            ["/test", "unit_test#post_required", "get", "test", "dummy"],
            ["/test", "unit_test#post_required", "post", "dummy", "dummy"],
            ["/test", "unit_test#post_required", "put", "test", "dummy"],
            ["/test", "unit_test#post_required", "delete", "test", "dummy"],
            ["/test", "unit_test#put_required", "get", "test", "dummy"],
            ["/test", "unit_test#put_required", "post", "test", "dummy"],
            ["/test", "unit_test#put_required", "put", "dummy", "dummy"],
            ["/test", "unit_test#put_required", "delete", "test", "dummy"],
            ["/test", "unit_test#delete_required", "get", "test", "dummy"],
            ["/test", "unit_test#delete_required", "post", "test", "dummy"],
            ["/test", "unit_test#delete_required", "put", "test", "dummy"],
            ["/test", "unit_test#delete_required", "delete", "dummy", "dummy"],
            ["/test", "unit_test#all_required", "get", "dummy", "dummy"],
            ["/test", "unit_test#all_required", "post", "dummy", "dummy"],
            ["/test", "unit_test#all_required", "put", "dummy", "dummy"],
            ["/test", "unit_test#all_required", "delete", "dummy", "dummy"],
            ["/test", "unit_test#get_equal", "get", "test", "dummy"],
            ["/test", "unit_test#post_equal", "post", "test", "dummy"],
            ["/test", "unit_test#put_equal", "put", "test", "dummy"],
            ["/test", "unit_test#delete_equal", "delete", "test", "dummy"],
            ["/test", "unit_test#all_equal", "get", "test", "dummy"],
            ["/test", "unit_test#all_equal", "post", "test", "dummy"],
            ["/test", "unit_test#all_equal", "put", "test", "dummy"],
            ["/test", "unit_test#all_equal", "delete", "test", "dummy"],
            ["/test", "unit_test#get_length", "get", "test", "dummy"],
            ["/test", "unit_test#post_length", "post", "test", "dummy"],
            ["/test", "unit_test#put_length", "put", "test", "dummy"],
            ["/test", "unit_test#delete_length", "delete", "test", "dummy"],
            ["/test", "unit_test#all_length", "get", "test", "dummy"],
            ["/test", "unit_test#all_length", "post", "test", "dummy"],
            ["/test", "unit_test#all_length", "put", "test", "dummy"],
            ["/test", "unit_test#all_length", "delete", "test", "dummy"],
            ["/test", "unit_test#get_max", "get", "test", "3.1"],
            ["/test", "unit_test#post_max", "post", "test", "3.1"],
            ["/test", "unit_test#put_max", "put", "test", "3.1"],
            ["/test", "unit_test#delete_max", "delete", "test", "3.1"],
            ["/test", "unit_test#all_max", "get", "test", "3.1"],
            ["/test", "unit_test#all_max", "post", "test", "3.1"],
            ["/test", "unit_test#all_max", "put", "test", "3.1"],
            ["/test", "unit_test#all_max", "delete", "test", "3.1"],
            ["/test", "unit_test#get_min", "get", "test", "0.9"],
            ["/test", "unit_test#post_min", "post", "test", "0.9"],
            ["/test", "unit_test#put_min", "put", "test", "0.9"],
            ["/test", "unit_test#delete_min", "delete", "test", "0.9"],
            ["/test", "unit_test#all_min", "get", "test", "0.9"],
            ["/test", "unit_test#all_min", "post", "test", "0.9"],
            ["/test", "unit_test#all_min", "put", "test", "0.9"],
            ["/test", "unit_test#all_min", "delete", "test", "0.9"],
            ["/test", "unit_test#get_max_length", "get", "test", "yuruyuri"],
            ["/test", "unit_test#post_max_length", "post", "test", "yuruyuri"],
            ["/test", "unit_test#put_max_length", "put", "test", "yuruyuri"],
            ["/test", "unit_test#delete_max_length", "delete", "test", "yuruyuri"],
            ["/test", "unit_test#all_max_length", "get", "test", "yuruyuri"],
            ["/test", "unit_test#all_max_length", "post", "test", "yuruyuri"],
            ["/test", "unit_test#all_max_length", "put", "test", "yuruyuri"],
            ["/test", "unit_test#all_max_length", "delete", "test", "yuruyuri"],
            ["/test", "unit_test#get_min_length", "get", "test", "yryr"],
            ["/test", "unit_test#post_min_length", "post", "test", "yryr"],
            ["/test", "unit_test#put_min_length", "put", "test", "yryr"],
            ["/test", "unit_test#delete_min_length", "delete", "test", "yryr"],
            ["/test", "unit_test#all_min_length", "get", "test", "yryr"],
            ["/test", "unit_test#all_min_length", "post", "test", "yryr"],
            ["/test", "unit_test#all_min_length", "put", "test", "yryr"],
            ["/test", "unit_test#all_min_length", "delete", "test", "yryr"],
            ["/test", "unit_test#get_number", "get", "test", "yryr"],
            ["/test", "unit_test#post_number", "post", "test", "yryr"],
            ["/test", "unit_test#put_number", "put", "test", "yryr"],
            ["/test", "unit_test#delete_number", "delete", "test", "yryr"],
            ["/test", "unit_test#all_number", "get", "test", "yryr"],
            ["/test", "unit_test#all_number", "post", "test", "yryr"],
            ["/test", "unit_test#all_number", "put", "test", "yryr"],
            ["/test", "unit_test#all_number", "delete", "test", "yryr"],
            ["/test", "unit_test#get_range", "get", "test", "-1"],
            ["/test", "unit_test#post_range", "post", "test", "-1"],
            ["/test", "unit_test#put_range", "put", "test", "-1"],
            ["/test", "unit_test#delete_range", "delete", "test", "-1"],
            ["/test", "unit_test#all_range", "get", "test", "-1"],
            ["/test", "unit_test#all_range", "post", "test", "-1"],
            ["/test", "unit_test#all_range", "put", "test", "-1"],
            ["/test", "unit_test#all_range", "delete", "test", "-1"],
            ["/test", "unit_test#get_range", "get", "test", "11"],
            ["/test", "unit_test#post_range", "post", "test", "11"],
            ["/test", "unit_test#put_range", "put", "test", "11"],
            ["/test", "unit_test#delete_range", "delete", "test", "11"],
            ["/test", "unit_test#all_range", "get", "test", "11"],
            ["/test", "unit_test#all_range", "post", "test", "11"],
            ["/test", "unit_test#all_range", "put", "test", "11"],
            ["/test", "unit_test#all_range", "delete", "test", "11"],
            ["/test", "unit_test#get_regexp", "get", "test", "yryr"],
            ["/test", "unit_test#post_regexp", "post", "test", "yryr"],
            ["/test", "unit_test#put_regexp", "put", "test", "yryr"],
            ["/test", "unit_test#delete_regexp", "delete", "test", "yryr"],
            ["/test", "unit_test#all_regexp", "get", "test", "yryr"],
            ["/test", "unit_test#all_regexp", "post", "test", "yryr"],
            ["/test", "unit_test#all_regexp", "put", "test", "yryr"],
            ["/test", "unit_test#all_regexp", "delete", "test", "yryr"]
        ];
    }

    public function validateDefinitionErrorProvider()
    {
        return [
            ["/test", "unit_test#invalid_rule_unknown"],
            ["/test", "unit_test#invalid_rule_required"],
            ["/test", "unit_test#invalid_rule_equal"],
            ["/test", "unit_test#invalid_rule_length1"],
            ["/test", "unit_test#invalid_rule_length2"],
            ["/test", "unit_test#invalid_rule_length3"],
            ["/test", "unit_test#invalid_rule_max"],
            ["/test", "unit_test#invalid_rule_min"],
            ["/test", "unit_test#invalid_rule_max_length"],
            ["/test", "unit_test#invalid_rule_min_length"],
            ["/test", "unit_test#invalid_rule_number"],
            ["/test", "unit_test#invalid_rule_range1"],
            ["/test", "unit_test#invalid_rule_range2"],
            ["/test", "unit_test#invalid_rule_regexp"],
            ["/test", "unit_test#invalid_validate_annotation1"],
            ["/test", "unit_test#invalid_validate_annotation2"],
            ["/test", "unit_test#duplicate_validate_rule"],
            ["/test", "unit_test#unknown_method"]
        ];
    }

    public function validateInvalidRequestMethodProvider()
    {
        return [
            ["/test", "unit_test#get_required"]
        ];
    }
}
