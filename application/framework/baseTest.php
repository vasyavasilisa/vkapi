<?php

namespace Application\Framework;

use PHPUnit\Framework\TestCase;
use Application\Framework\Browser;
use Application\Framework\Logger;

abstract class BaseTest extends TestCase
{
    public abstract function doTest();

    /**
     * @test
     */
    public function xTest(){
        $this->doTest();
    }

    public static function getBrowser()
    {
        return Browser::getMyDriver();
    }

    /**
     * @beforeClass
     */
    public static function before()
    {
        $browser = self::getBrowser();
        $browser->manage()->window()->maximize();
        $browser->get($GLOBALS["url"]);
    }


    /**
     * @afterClass
     */
    public static function after()
    {
        // self::getBrowser()->close();
    }

    public function logStep($stepText){
        Logger::getInstance()->step($stepText);
    }
}