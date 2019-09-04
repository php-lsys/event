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
     * @param EventObserver $observer
     * @return $this
     */
    public function attach(EventObserver $observer){
        $name=$observer->eventName();
        if (is_string($name))$name=[$name];
        foreach ($name as $v) $this->storage[$v][]=$observer;
        return $this;
    }
    /**
     * check callback in listen
     * return event name
     * @param EventObserver $observer
     * @return array
     */
    public function contains (EventObserver $observer) {
        $name=$observer->eventName();
        if (is_string($name))$name=[$name];
        $outname=[];
        foreach ($name as $v){
            foreach ($this->storage[$v]??[] as $ob){
                if($ob===$observer)$outname[]=$v;
            }
        }
        return $outname;
    }
    /**
     * detach callback on listen
     * @param EventObserver $observer
     * @return bool
     */
    public function detach(EventObserver $observer){
        $name=$observer->eventName();
        if (is_string($name))$name=[$name];
        $deatch=0;
        foreach ($name as $v){
            foreach ($this->storage[$v]??[] as $k=>$ob){
                if($ob===$observer){
                    unset($this->storage[$v][$k]);
                    $deatch++;
                }
            }
        }
        return $deatch;
    }
    /**
     * detach all callback on listen
     * @param string $event
     * @return boolean
     */
    public function detachAll($event_name){
        $this->storage[$event_name]=[];
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