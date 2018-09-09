<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
/**
 * @method \LSYS\EventManager event_manager()
 */
class DI extends \LSYS\DI{
    /**
     * @return static
     */
    public static function get(){
        $di=parent::get();
        !isset($di->event_manager)&&$di->event_manager(new \LSYS\DI\SingletonCallback(function (){
            return new \LSYS\EventManager();
        }));
        return $di;
    }
}
