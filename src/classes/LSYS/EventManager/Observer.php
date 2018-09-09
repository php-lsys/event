<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
interface Observer extends \SplObserver{
    /**
     * @param Subject $subject
     * {@inheritDoc}
     * @see \SplObserver::update()
     */
    public function update(\SplSubject $subject);
}