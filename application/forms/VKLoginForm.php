<?php

namespace Application\Forms;

use Application\Framework\TextBox;
use Application\Framework\Button;
use Facebook\WebDriver\WebDriverBy;
use Application\Framework\BaseForm;

class VKLoginForm extends BaseForm
{
    private static $loginBlock = "//div[@id='index_login']";
    private static $loginTxt = "//form[@id='index_login_form']/input[@id='index_email']";
    private static $passwordTxt = "//form[@id='index_login_form']/input[@id='index_pass']";
    private static $enterBtn = "//form[@id='index_login_form']/button[@id='index_login_button']";

    public function __construct()
    {
        parent::initForm(WebDriverBy::xpath(self::$loginBlock), "Vkontacte Main Form");

    }

    public function login($login, $password)
    {
        {
            $loginTxb = new TextBox(WebDriverBy::xpath(self::$loginTxt), "Login Text Box");
            $loginTxb->type($login);
            $passwordTxb = new TextBox(WebDriverBy::xpath(self::$passwordTxt), "Password Text Box");
            $passwordTxb->type($password);
            $submitBtn = new Button(WebDriverBy::xpath(self::$enterBtn), "Submit Button");
            $submitBtn->submit();

        }
    }
}