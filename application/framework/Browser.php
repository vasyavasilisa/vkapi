<?php

namespace Application\Framework;

use Application\Framework\Firefox;
use Application\Framework\Chrome;
use PHPUnit\Framework\TestCase;

/**
 * Class Browser
 */
class Browser
{
    const ENV_NAME_BROWSER_TYPE = "browser";
    protected static $host;

    public static function getMyDriver()
    {
        $browserType = getenv(self::ENV_NAME_BROWSER_TYPE);
        self::$host = $GLOBALS["serverHostLocal"];
        $isRemote = getenv("isRemote");
        TestCase::assertTrue($isRemote, "isRemote=" . $isRemote);
        if( $isRemote == True){
        self::$host = $GLOBALS["serverHostVM"];
        }
        switch ($browserType) {
            case "chrome":
                {
                    $driver = Chrome::getInstance();
                    return $driver;
                }
            case "firefox":
                {
                    $driver = Firefox::getInstance();
                    return $driver;
                }

        }
    }

}