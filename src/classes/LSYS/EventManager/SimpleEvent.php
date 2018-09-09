<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
class SimpleEvent extends Event{
    protected $_name;
    protected $_param;
    public function __construct($name,array $param=[]){
        $this->_name=$name;
        $this->_param=$param;
    }
    public function name(){
        return $this->_name;
    }
    public function __get($cloumn){
        if (!isset($this->_param[$cloumn]))return null;
        return $this->_param[$cloumn];
    }
}