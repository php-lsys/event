<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
use LSYS\EventManager;

class Subject implements \SplSubject{
    /**
     * @var \SplObjectStorage
     */
    private $storage;
    /**
     * @var bool Whether no further event listeners should be triggered
     */
    private $propagationStopped = false;
    private $event_class;
    private $event_obj;
    private $event_mgr;
    public function __construct($event_class){
        $this->storage= new \SplObjectStorage();
        $this->event_class=$event_class;
    }
    public function isMatch(Event $event){
        return $event instanceof $this->event_class;
    }
    /**
     * Returns whether further event listeners should be triggered.
     * @return bool Whether propagation was already stopped for this event
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }
    /**
     * Stops the propagation of the event to further event listeners.
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }
    /**
     * @param Observer $observer
     * {@inheritDoc}
     * @see \SplSubject::attach()
     */
    public function attach(\SplObserver $observer,$priority = 0){//
        $this->storage->attach($observer,$priority);
        return $this;
    }
    /**
     * contains an SplObserver
     * @param Observer $observer
     * @return boolean
     */
    public function contains ($observer) {
        return $this->storage->contains($observer);
    }
    /**
     * @param Observer $observer
     * {@inheritDoc}
     * @see \SplSubject::detach()
     */
    public function detach(\SplObserver $observer){//
        $this->storage->detach($observer);
        return $this;
    }
    /**
     * get trigger notify event
     * @return \LSYS\EventManager\Event
     */
    public function event(){
        return $this->event_obj;
    }
    /**
     * get trigger notify event
     * @return \LSYS\EventManager
     */
    public function eventManager(){
        return $this->event_mgr;
    }
    /**
     * {@inheritDoc}
     * @see \SplSubject::notify()
     */
    public function notify(Event $event=null,EventManager $event_manager=null){
        $this->event_obj=$event;
        $this->event_mgr=$event_manager;
        $key=$value=[];
        foreach ($this->storage as $v){
            $index=$this->storage[$v];
            $key[]=$index;
            $value[]=$v;
        }
        arsort($key,SORT_NUMERIC);
        foreach ($key as $k=>$_){
            if ($this->isPropagationStopped())break;
            $value[$k]->update($this);
        }
        unset($key,$value);
        return $this;
    }
}

