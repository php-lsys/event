<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
use LSYS\EventManager\Event;
class EventManager{
    /**
     * @var array
     */
    protected $storage=[];
    /**
     * add callback in listen
     * @param string $event
     * @param callable $callable
     * @return \LSYS\EventManager
     */
    public function attach($event,callable $callable,$handle=null){
        if(is_null($handle))$this->storage[$event][]=$callable;
        $this->storage[$event][$handle]=$callable;
        return $this;
    }
    /**
     * check callback in listen
     * @param string $event
     * @param callable $callable
     * @return boolean
     */
    public function contains ($event,callable $callable) {
        foreach ($this->storage[$event] as $v){
            if($v===$callable)return true;
        }
        return false;
    }
    /**
     * detach callback on listen
     * @param string $event
     * @param callable $callable
     * @return boolean
     */
    public function detach($event,$callable){//
        foreach ($this->storage[$event] as $k=>$v){
            if (is_callable($callable)) {
                if($v===$callable)unset($this->storage[$event][$k]);
            }else unset($this->storage[$event][$callable]);
        }
        return false;
    }
    /**
     * detach all callback on listen
     * @param string $event
     * @return boolean
     */
    public function detachAll($event){//
        $this->storage[$event]=[];
        return true;
    }
    /**
     * dispatch listen
     */
    public function dispatch(Event $event){
        foreach ($this->storage as $k=>$v){
            if($k==$event->getName()){
                foreach ($v as $c){
                    call_user_func($c,$event);
                    if($event->isPropagationStopped())break;
                }
                break;
            }
        }
    }
}