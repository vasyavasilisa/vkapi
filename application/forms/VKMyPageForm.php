<?php

namespace Application\Forms;

use Application\Framework\Label;
use Application\Framework\Button;
use Application\Framework\Link;
use Facebook\WebDriver\WebDriverBy;
use Application\Framework\BaseForm;

class VKMyPageForm extends BaseForm
{
    private static $postBlockLoc ="//div[contains(@id,'%s')]";
    private static $postAutorLblLoc = "//a[@class = 'author' and contains(@href, '%s')]";
    private static $postMessageLblLoc = "//div[contains(@class , 'wall_post_text') and text()='%s']";
    private static $imageInkLoc = "//a[contains(@href, '%s')]";
    private static $commentLblLoc = "//div[contains(@id, '%s_%s')]//div[@class='wall_reply_text' and text() = '%s']";
    private static $likeBtnLoc = "//*[contains(@class,'post_like_icon')]";
    private static $avatarImgLoc = "//*[contains(@class, 'page_avatar_img')]";


    /**
     * VKMyPageForm constructor.
     */
    public function __construct()
    {
        parent::initForm(WebDriverBy::xpath(self::$avatarImgLoc), "Vkontacte My Page Form");

    }

    public function isPostWithRightAuthorPresent($postId, $userId)
    {
        $postAutorLblLoc = new Label(WebDriverBy::xpath(sprintf(self::$postBlockLoc . self::$postAutorLblLoc, $postId, $userId)), "Post's Author Label");
        $postAutorLblLoc->assertIsPresent();
    }


    public function isPostWithRightTextPresent($postId, $message)
    {
        $postMessageLbl = new Label(WebDriverBy::xpath(sprintf(self::$postBlockLoc . self::$postMessageLblLoc, $postId, $message)), "Post's text Label");
        $postMessageLbl->assertIsPresent();

    }

    public function isPostWithRightImagePresent($postId, $photoId)
    {
        $postMessageLbl = new Link(WebDriverBy::xpath(sprintf(self::$postBlockLoc . self::$imageInkLoc, $postId, $photoId)), "Post's image link");
        $postMessageLbl->assertIsPresent();

    }

    public function isCommentPresent($userFromId, $postId, $comment)
    {
        $postMessageLbl = new Label(WebDriverBy::xpath(sprintf(self::$commentLblLoc, $userFromId, $postId, $comment)), "Comment Label");
        $postMessageLbl->assertIsPresent();

    }

    public function leaveLike($postId)
    {
        $likeBtn = new Button(WebDriverBy::xpath(sprintf(self::$postBlockLoc . self::$likeBtnLoc, $postId)), "Like Button");
        $likeBtn->click();
    }

    public function assertPostAbsent($postId)
    {
        $postMessageLbl = new Label(WebDriverBy::xpath(sprintf(self::$postBlockLoc, $postId)), "Post Label");
        $postMessageLbl->assertIsAbsent();

    }
}




