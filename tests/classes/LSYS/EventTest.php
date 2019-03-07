<?php
namespace LSYS;
use PHPUnit\Framework\TestCase;
final class EventTest extends TestCase
{
    public function testevent()
    {
        $em=new \LSYS\EventManager();
        $subject=new \LSYS\EventManager\Subject(\LSYS\EventManager\SimpleEvent::class);
        $observer=new \LSYS\EventManager\CallbackObserver(function(\LSYS\EventManager\Subject $subject){
            $this->assertEquals($subject->event()->name(), "test_event_name");
            $this->assertEquals($subject->event()->test_param, "test data");
        });
        $subject->attach($observer);
        $this->assertTrue($subject->contains($observer));
        $em->attach($subject);
        $this->assertTrue($em->contains($subject));
        $em->dispatch(new \LSYS\EventManager\SimpleEvent("test_event_name",['test_param'=>'test data']));
        $this->assertInstanceOf(\LSYS\EventManager::class, \LSYS\EventManager\DI::get()->eventManager());
        
        
        
        $em->detach($subject);
        $this->assertFalse($em->contains($subject));
        
        $subject->detach($observer);
        $this->assertFalse($subject->contains($observer));
        
    }
}