<?php
namespace TestEvent;
use PHPUnit\Framework\TestCase;
use LSYS\EventManager\DI;
include_once __DIR__.'/TestEvent.php';
final class EventTest extends TestCase
{
    public function testDispatch()
    {
        $data=null;
        $call=new \LSYS\EventManager\EventCallback(function(TestEvent $event)use(&$data){
            $data=$event->data("sql");
        });
        DI::get()->eventManager()->attach(TestEvent::name(TestEvent::TEST),$call);
        DI::get()->eventManager()->dispatch(new TestEvent(TestEvent::TEST,["sql"=>"1"]));
        $this->assertTrue($data=="1");
        DI::get()->eventManager()->detach(TestEvent::name(TestEvent::TEST),$call);
        DI::get()->eventManager()->dispatch(new TestEvent(TestEvent::TEST,["sql"=>"2"]));
        $this->assertTrue($data=="1");
        DI::get()->eventManager()->attach(TestEvent::name(TestEvent::TEST),$call,"test_handle");
        DI::get()->eventManager()->dispatch(new TestEvent(TestEvent::TEST,["sql"=>"3"]));
        $this->assertTrue($data=="3");
    }
}