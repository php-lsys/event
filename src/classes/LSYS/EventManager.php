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
    public function attach(EventObserver $observer,int $priority=0){
        $name=$observer->eventName();
        if (is_string($name))$name=[$name];
        foreach ($name as $v) $this->storage[$v][]=array($observer,$priority);
        return $this;
    }
    /**
     * check callback in listen
     * return event name
     * @param EventObserver $observer
     * @return array
     */
    public function contains (EventObserver $observer):array {
        $name=$observer->eventName();
        if (is_string($name))$name=[$name];
        $outname=[];
        foreach ($name as $v){
            foreach ($this->storage[$v]??[] as $ob){
                if($ob[0]===$observer)$outname[]=$v;
            }
        }
        return $outname;
    }
    /**
     * detach callback on listen
     * @param EventObserver $observer
     * @return bool
     */
    public function detach(EventObserver $observer):bool{
        $name=$observer->eventName();
        if (is_string($name))$name=[$name];
        $deatch=0;
        foreach ($name as $v){
            foreach ($this->storage[$v]??[] as $k=>$ob){
                if($ob[0]===$observer){
                    unset($this->storage[$v][$k]);
                    $deatch++;
                }
            }
        }
        return $deatch;
    }
    /**
     * return listen event name list
     * @return array
     */
    public function getAttachEvent():array{
        return array_keys($this->storage);
    }
    /**
     * return event name is add observer list
     * @param string $event_name
     * @return EventObserver[]
     */
    public function getAttachObserver(string $event_name):array{
        return $this->storage[$event_name]??[];
    }
    /**
     * detach all callback on listen
     * @param string $event
     * @return boolean
     */
    public function detachAll(string $event_name):bool{
        $this->storage[$event_name]=[];
        return true;
    }
    /**
     * dispatch listen
     */
    public function dispatch(Event $event):void{
        $priority=[];
        $v=$this->storage[$event->getName()]??[];
        foreach ($v as $k=>$c){
            $priority[$k]=$c[1];
        }
        arsort($priority);
        foreach (array_keys($priority) as $k){
            $v[$k][0]->eventNotify($event);
            if($event->isPropagationStopped())break;
        }
    }
}