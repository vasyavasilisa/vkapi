<?php

namespace Application\Framework;

use Application\Framework\BaseElement;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeOutException;

/**
 * Class TextBox
 */
class TextBox extends BaseElement
{

    public function __construct($loc, $nameOf)
    {
        parent::__construct($loc, $nameOf);
    }

    public function type($value)
    {
        $this->waitForElementIsPresent();
        Logger::getInstance()->step("Element " . $this->name . " sending keys");
        $this->element->sendKeys($value);
    }
}