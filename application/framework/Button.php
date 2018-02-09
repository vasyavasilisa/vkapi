<?php

namespace Application\Framework;

use Application\Framework\BaseElement;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeOutException;

/**
 * Class Button
 */
class Button extends BaseElement
{

    public function __construct($loc, $nameOf)
    {
        parent::__construct($loc, $nameOf);
    }

    public function submit()
    {
        $this->waitForElementIsPresent();
        Logger::getInstance()->step("Element " . $this->name . " submit");
        $this->element->submit();
    }
}