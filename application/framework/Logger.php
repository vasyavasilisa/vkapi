<?php

namespace Application\Framework;
use Katzgrau\KLogger\Logger as KLogger;
/**
 * Class Logger
 */
final class Logger
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function step($step) {
        $logger = new KLogger(__DIR__.'/logs');
        $logger->info(sprintf("--------==[ Step %s ]==--------", $step));
}
    public function fatal($message) {
        $logger = new KLogger(__DIR__.'/logs');
        $logger->error(sprintf($message));
    }

}