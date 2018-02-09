<?php

namespace Application\Forms;

use Application\Framework\Link;
use Facebook\WebDriver\WebDriverBy;
use Application\Framework\BaseForm;

class VKNewsForm extends BaseForm
{
    private static $leftMenuLocator = "//*[text()='%s']/ancestor::a";
    private static $hotNewsLbl = "//div[@class='ui_toggler_wrap hot']";


    public function __construct()
    {
        parent::initForm(WebDriverBy::xpath(self::$hotNewsLbl), "Vkontacte News Form");

    }

    public function navigateLeftMenu($menuItem)
    {
        {
            $leftMenuLnk = new Link(WebDriverBy::xpath(sprintf (self::$leftMenuLocator, $menuItem)), "Left Menu Link");
            $leftMenuLnk->click();
        }
    }

}




