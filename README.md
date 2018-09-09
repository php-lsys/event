事件管理
===

[![Build Status](https://travis-ci.com/lsys/event.svg?branch=next_version)](https://travis-ci.com/lsys/event)
[![Coverage Status](https://coveralls.io/repos/github/lsys/event/badge.svg?branch=next_version)](https://coveralls.io/github/lsys/event?branch=next_version)

> 事件管理基类,用于代码解耦


创建事件管理

```
$em=new LSYS\EventManager();
```

定义事件处理

```
$subject=new LSYS\EventManager\Subject(LSYS\EventManager\SimpleEvent::class);
$subject->attach(new LSYS\EventManager\CallbackObserver(function(LSYS\EventManager\Subject $subject){
    var_dump($subject->event()->name());//test_event_name
    var_dump($subject->event()->test_param);//test data
}));
$em->attach($subject);
```

派发事件

```
$em->dispatch(new LSYS\EventManager\SimpleEvent("test_event_name",['test_param'=>'test data']));
```

> 更多使用细节参考 dome/dome.php