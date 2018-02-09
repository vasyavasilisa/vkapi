<?php

namespace Application\Framework;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseForm
 */
class BaseForm extends TestCase
{

    protected $titleLocator;
    protected $title;
    private static $menu = array(
        'myPage' => 'Моя Страница',
        'news' => 'Новости',
        'messages' => 'Сообщения',
        'friends' => 'Друзья',
        'fotos' => 'Фотографии',
    );

    /**
     * @return array
     */
    public function getMenu(): array
    {
        return self::$menu;
    }

    protected function initForm($locator, $formTitle)
    {
        $this->titleLocator = $locator;
        $this->title = $formTitle;
        $this->assertIsOpen();
    }

    public function assertIsOpen()
    {
        $label = new Label($this->titleLocator, $this->title);
        try {
            $label->waitForElement();
        } catch (Exception | \Facebook\WebDriver\Exception\NoSuchElementException | \Facebook\WebDriver\Exception\TimeOutException $e) {
            $this->fail($this->title . " did not appear");
        }
    }

    public function getElements($locator)
    {
        return Browser::getMyDriver()->findElements($locator);
    }
}