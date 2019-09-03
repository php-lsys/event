<?php
use LSYS\EventManager\DI;
use LSYS\EventManager\Event;
include_once __DIR__."/../vendor/autoload.php";
class eventitem extends Event{
    const AAA="BBB";
}
DI::get()->eventManager()->attach(eventitem::name(eventitem::AAA),new \LSYS\EventManager\EventCallback(function(eventitem $event){
    $sql=$event->data("sql");
    var_dump($sql);
}));
//使用全局事件管理器进行事件派发
class dome_pppp{
    public function add(){
        DI::get()->eventManager()->dispatch(new eventitem(eventitem::AAA,["sql"=>"fasd"]));//为每个事件定义一个类
    }
}
//执行代码
$ppp=new dome_pppp;
$ppp->add();

