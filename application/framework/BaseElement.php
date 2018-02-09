<?php

namespace Application\Framework;

use Application\Framework\Browser;
use Exception;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeOutException;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PhpCsFixer\Tests\TestCase;
use Application\Framework\Logger;

/**
 * Class BaseElement
 */
abstract class BaseElement extends TestCase
{
    const WAIT_TIMEOUT = 20;
    const WAIT_INTERVAL = 2000;

    protected $name;
    protected $locator;
    protected $element;

    protected function __construct($loc, $nameOf)
    {
        $this->locator = $loc;
        $this->name = $nameOf;
    }

    /**
     * @throws Exception
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     * @throws \Exception
     */
    public function waitForElementAbsent()
    {
        Browser::getMyDriver()->wait(self::WAIT_TIMEOUT, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated($this->locator)
        );
    }

    /**
     * @throws Exception
     * @throws NoSuchElementException
     * @throws TimeOutException
     */
    public function waitForElement()
    {
        Browser::getMyDriver()->wait(self::WAIT_TIMEOUT, self::WAIT_INTERVAL)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated($this->locator));
        $this->element = Browser::getMyDriver()->findElement($this->locator);
    }

    public function waitForElementIsPresent()
    {
        $isPresent = FALSE;
        try {
            $isPresent = $this->isPresent();
        } catch (Exception | NoSuchElementException | TimeOutException $e) {
            Logger::getInstance()->fatal("Element " . $this->name . " is absent");
        }
        self::assertTrue($isPresent, "Element " . $this->name . " is absent");

    }

    /**
     * @return mixed
     * @throws Exception
     * @throws NoSuchElementException
     * @throws TimeOutException
     */
    public function isPresent()
    {
        $this->waitForElement();
        $isVisible = $this->element->isDisplayed();
        return $isVisible;
    }

    public function click()
    {
        $this->waitForElementIsPresent();
        Logger::getInstance()->step("Element " . $this->name . " clicking");
        $this->element->click();
    }

    public function getText()
    {
        $this->waitForElementIsPresent();
        $this->element->getText();
    }

    public function assertIsPresent()
    {
        $this->waitForElementIsPresent();
    }

    public function assertIsAbsent()
    {
        try {
            $this->waitForElementAbsent();
            Logger::getInstance()->step("Element " . $this->name . " is absent");
        } catch (NoSuchElementException | TimeOutException | Exception $e) {
            Logger::getInstance()->fatal("Element " . $this->name . " is present");
        }
    }

}