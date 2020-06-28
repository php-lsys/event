<?php
/**
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
if(!function_exists("func_get_argsname")){
    /**
     * 得到当前函数的参数列表名
     * @return array
     */
    function func_get_argsname() {
        $var=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
        if(count($var)!=2)return [];
        if(isset($var[1]['class'])){
            return array_column((new \ReflectionMethod($var[1]['class']."::".$var[1]['function']))->getParameters(), "name");
        }else{
            return array_column((new \ReflectionFunction($var[1]['function']))->getParameters(), "name");
        }
    }
}