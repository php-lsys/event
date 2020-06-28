<?php
/**
 * lsys event
 * @author     Lonely <shan.liu@msn.com>
 * @copyright  (c) 2017 Lonely <shan.liu@msn.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace LSYS\EventManager;
abstract class Event{
    private $propagationStopped = false;
    private $name;
    private $data;
    protected function __construct(string $name=null,array $data=[]){
        $this->name=$name;
        $this->data=$data;
    }
    /**
     * get event name
     * @return string
     */
    public function getName():string{
        return $this->name;
    }
    /**
     * get event data
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function data(?string $key=null,$default=null){
        if(is_null($key)) return $this->data;
        return $this->data[$key]??$default;
    }
    /**
     * check is stop Propagation
     * @return bool
     */
    public function isPropagationStopped():bool
    {
        return $this->propagationStopped;
    }
    /**
     * set stop Propagation
     * @return $this
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;
        return $this;
    }
}