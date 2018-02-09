<?php

namespace Application\Framework;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Application\Framework\Browser;

/**
 * Class Firefox
 */
class Chrome extends Browser{

    private static $chromeDriver = null;

    public static function getInstance(){

        if (self::$chromeDriver == null)
            self::$chromeDriver = RemoteWebDriver::create(parent::$host, DesiredCapabilities::chrome());
        return self::$chromeDriver;
    }
}