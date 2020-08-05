<?php
namespace TestEvent;
use PHPUnit\Framework\TestCase;
use LSYS\EventManager\DI;
include_once __DIR__.'/TestEvent.php';
final class TestEventTest extends TestCase
{
    public function testDispatch()
    {
        $data=null;
        $call=new \LSYS\EventManager\EventCallback(TestEvent::TEST,function(TestEvent $event)use(&$data){
            $data=(array)$event->getData()["sql"];
            $event->stopPropagation();
        },1);
        DI::get()->eventManager()->attach($call);
        $call1=new \LSYS\EventManager\EventCallback(TestEvent::TEST,function(TestEvent $event)use(&$data){
            $data=3;
        },0);
        DI::get()->eventManager()->attach($call1);
        DI::get()->eventManager()->dispatch(TestEvent::test(1));
        $this->assertTrue(count(DI::get()->eventManager()->contains($call))==1);
        $this->assertEquals($data,"1");
        $this->assertTrue(in_array(TestEvent::TEST, DI::get()->eventManager()->getAttachEvent()));
        DI::get()->eventManager()->detach($call);
        DI::get()->eventManager()->detach($call1);
        DI::get()->eventManager()->dispatch(TestEvent::test(3));
        $this->assertEquals($data,"1");
        DI::get()->eventManager()->attach($call);
        DI::get()->eventManager()->dispatch(TestEvent::test(3));
        $this->assertTrue($data=="3");
        DI::get()->eventManager()->detachAll(TestEvent::TEST);
        $this->assertTrue(empty(DI::get()->eventManager()->getAttachObserver(TestEvent::TEST)));
    }
}