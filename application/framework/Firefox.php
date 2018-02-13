<?php

namespace Application\Framework;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Application\Framework\Browser;

/**
 * Class Firefox
 */

class Firefox extends Browser{

    private static $firefoxDriver = null;

    public static function getInstance(){

        if (self::$firefoxDriver == null)
            self::$firefoxDriver = RemoteWebDriver::create(parent::$host, DesiredCapabilities::firefox(), 5000, 5000);
        return self::$firefoxDriver;
    }
}