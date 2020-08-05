<?php
namespace TestEvent;
use LSYS\EventManager\Event;
class TestEvent extends Event{
    //建议小写并用.号分割
    const TEST="test.dome";
    public static function test($sql) {
        return new static(static::TEST,func_get_args());
    }
}