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
        $call=new \LSYS\EventManager\EventCallback(TestEvent::TEST,function(TestEvent $event)use(&$data){
            $data=$event->data("sql");
        });
        DI::get()->eventManager()->attach($call);
        DI::get()->eventManager()->dispatch(TestEvent::test(1));
        $this->assertEquals($data,"1");
        DI::get()->eventManager()->detach($call);
        DI::get()->eventManager()->dispatch(TestEvent::test(3));
        $this->assertEquals($data,"1");
        DI::get()->eventManager()->attach($call);
        DI::get()->eventManager()->dispatch(TestEvent::test(3));
        $this->assertTrue($data=="3");
    }
}