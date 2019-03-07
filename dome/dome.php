<?php
use LSYS\EventManager\Subject;
use LSYS\EventManager\Observer;
use LSYS\EventManager\DI;
use LSYS\EventManager\Event;
use LSYS\EventManager;
use LSYS\EventManager\SimpleEvent;
use LSYS\EventManager\CallbackObserver;
include_once __DIR__."/../vendor/autoload.php";


//-------------------往代码添加事件--------------------
//定义DI 实现event_manager的全局控制还是局部方式
// class dome_mydi extends DI implements \LSYS\EventManager\DI{
//     /**
//      * @return EventManager
//      */
//     public function eventManager(){
//         //default di
//         return self::get()->eventManager();
//     }
// }
//

//自定义事件类,可以不定义使用 SimpleEvent 通用事件
//定义事件类 使用清晰 通过注释可以清晰描述每个事件的详细情况,使用SimpleEvent 使用方便些 各有各的好
class eventitem extends Event{
    public $param;
    public function __construct($param){
        $this->param=$param;
    }
}
//使用全局事件管理器进行事件派发
class dome_pppp{
    public function add(){
        DI::get()->eventManager()->dispatch(new eventitem(111));//为每个事件定义一个类
        DI::get()->eventManager()->dispatch(new SimpleEvent("test",['test_param1'=>'test param']));//懒得为每个事件定义一个类,可以派发一个通用事件.
    }
}
//使用内部事件管理器进行事件派发
class dome_pppp1{
    public $event_mgr;
    public function __construct(){
        $this->event_mgr=new EventManager();
    }
    public function add(){
        //使用全局事件管理器进行事件派发
        $this->event_mgr->dispatch(new eventitem(111));
    }
}






//-------------------注册事件处理---------------------------
$eventsubsss=new Subject(eventitem::class);
//定义类方式处理
class dome_call1 implements Observer{
    public function update($subject){
        $event=$subject->event();
        assert($event instanceof eventitem);
        var_dump($event->param);
        //$subject->stopPropagation();//停止继续派发
    }
}
$eventsubsss->attach(new dome_call1);
//定义回调函数方式处理
$eventsubsss->attach(new CallbackObserver(function(Subject $subject){
    if ($subject->eventManager()!==DI::get()->eventManager()){
        var_dump("inner object dispatch");
    }
    var_dump($subject->event()->param);
}),10);


$eventsubsss1=new Subject(SimpleEvent::class);
$eventsubsss1->attach(new CallbackObserver(function(Subject $subject){
    $event=$subject->event();
    assert($event instanceof SimpleEvent);
    if($event->name()=='test'){//只处理名为 test 的事件,可能有其他地方也会派发此事件
        var_dump($event->test_param1);
    }
}));

//往全局事件管理器添加监听
DI::get()->eventManager()->attach($eventsubsss);
DI::get()->eventManager()->attach($eventsubsss1);//通用事件简单监听
//执行代码
$ppp=new dome_pppp;
$ppp->add();

// 对内部事件管理器添加监听
$ppp1=new dome_pppp1;
$ppp1->event_mgr->attach($eventsubsss);
$ppp1->add();
