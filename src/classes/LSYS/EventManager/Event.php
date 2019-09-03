<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
abstract class Event{
    public static function name($name) {
        return str_replace("\\", ".", get_called_class()).'.'.$name;
    }
    private $propagationStopped = false;
    private $name;
    private $data;
    public function __construct($name=null,array $data=[]){
        $this->name=self::name($name);
        $this->data=$data;
    }
    public function getName(){
        return $this->name;
    }
    public function data($key=null,$default=null){
        if(is_null($key)) return $this->data;
        return $this->data[$key]??$default;
    }
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }
    public function stopPropagation()
    {
        $this->propagationStopped = true;
        return $this;
    }
}