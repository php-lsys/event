<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
use LSYS\EventManager\Event;
use LSYS\EventManager\EventObserver;

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
    public function attach(EventObserver $observer){
        $this->storage[$observer->eventName()][]=$observer;
        return $this;
    }
    /**
     * check callback in listen
     * @param string $event
     * @param callable $callable
     * @return boolean
     */
    public function contains (EventObserver $observer) {
        foreach ($this->storage[$observer->eventName()]??[] as $v){
            if($v===$observer)return true;
        }
        return false;
    }
    /**
     * detach callback on listen
     * @param string $event
     * @param callable $callable
     * @return boolean
     */
    public function detach($observer){
        $event=$observer->eventName();
        foreach ($this->storage[$event]??[] as $k=>$v){
            if($v===$observer)unset($this->storage[$event][$k]);
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
        $v=$this->storage[$event->getName()]??[];
        foreach ($v as $c){
            $c->eventNotify($event);
            if($event->isPropagationStopped())break;
        }
    }
}