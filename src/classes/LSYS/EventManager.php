<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS;
use LSYS\EventManager\Subject;
use LSYS\EventManager\Event;
class EventManager{
    /**
     * @var \SplObjectStorage
     */
    public $storage;
    /**
     * event manage and dispatch
     */
    public function __construct(){
        $this->storage = new \SplObjectStorage();
    }
    /**
     * add Subject to listen
     * @param Subject $subject
     */
    public function attach(Subject $subject){
        $this->storage->attach($subject);
    }
    /**
     * check Subject in listen
     * @param Subject $subject
     */
    public function contains (Subject $subject) {
        return $this->storage->contains($subject);
    }
    /**
     * detach Subject on listen
     * @param Subject $subject
     */
    public function detach(Subject $subject=null){//
        $this->storage->detach($subject);
    }
    /**
     * dispatch listen
     */
    public function dispatch(Event $event){
        foreach ($this->storage as $v){
            assert($v instanceof Subject);
            if($v->isMatch($event)){
                $v->notify($event,$this);
            }
        }
    }
}