<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
final class CallbackObserver implements Observer
{
    /**
     * @var callable
     */
    protected $_callable;
    public function __construct(callable $callable){
        $this->_callable=$callable;
    }
   /**
    * @param Subject $subject
    * {@inheritDoc}
    * @see \LSYS\EventManager\Observer::update()
    */
    public function update(\SplSubject $subject)
    {
        call_user_func($this->_callable,$subject);
    }
}
