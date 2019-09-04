<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
interface EventObserver{
    /**
     * listen event name
     * @return string||array
     */
    public function eventName();
    /**
     * listen callback function
     * @param Event $event
     */
    public function eventNotify(Event $event);
}