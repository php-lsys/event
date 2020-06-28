<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
class EventCallback implements EventObserver {
    protected $name;
    protected $callback;
    /**
     * callback event observer
     * @param string|array $name 
     * @param callable $callback
     */
    public function __construct($name,callable $callback)
    {
        $this->name=$name;
        $this->callback=$callback;
    }
    /**
     * {@inheritDoc}
     * @see \LSYS\EventManager\EventObserver::eventName()
     */
    public function eventName(){
        return $this->name;
    }
    /**
     * {@inheritDoc}
     * @see \LSYS\EventManager\EventObserver::eventNotify()
     */
    public function eventNotify(Event $event){
        return call_user_func($this->callback,$event);
    }
}