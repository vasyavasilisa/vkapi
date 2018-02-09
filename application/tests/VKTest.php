<?php

namespace Application\Framework\Tests;

use Application\Forms\VKNewsForm;
use Application\Framework\BaseTest;
use Application\Forms\VKLoginForm;
use Application\Forms\VKMyPageForm;
use Application\Framework\Utils\VkApiUtils;
use Application\Framework\Utils\StringUtils;


/**
 * Class VKTest
 * @package Application\Framework\Tests
 */
class VKTest extends BaseTest
{

    public function doTest()
    {
        parent::logStep("Login in VK");
        $vkLoginForm = new VKLoginForm();
        $vkLoginForm->login($GLOBALS["login"], $GLOBALS["password"]);

        parent::logStep("Go To My Page");
        $vkNewsForm = new VKNewsForm();
        $vkNewsForm->navigateLeftMenu($vkNewsForm->getMenu()['myPage']);

        parent::logStep("Post Record On The Wall");
        $message = StringUtils::generateRandText();
        $vkApiUtils =  new VkApiUtils($GLOBALS["token"]);
        $userId = $vkApiUtils->getUserInfo();
        $postId = $vkApiUtils->postRecordOnWall($message);

        parent::logStep("Check record On The Wall");
        $vkMyPageForm = new VKMyPageForm();
        $vkMyPageForm->isPostWithRightAuthorPresent($postId, $userId);
        $vkMyPageForm->isPostWithRightTextPresent($postId, $message);

        parent::logStep("Edit Record Text And Upload Image");
        $newMessage = StringUtils::generateRandText();
        $photoId = $vkApiUtils->saveWallPhoto();
        $vkApiUtils->editRecordWithAttachments($postId, $newMessage, "photo" . $userId . "_" . $photoId);

        parent::logStep("Check Record Was Changed After Updating");
        $vkMyPageForm->isPostWithRightTextPresent($postId, $newMessage);
        $vkMyPageForm->isPostWithRightImagePresent($postId, $photoId);

        parent::logStep("Leave Comment To The Record");
        $comment = StringUtils::generateRandText();
        $vkApiUtils->createComment($postId, $comment);

        parent::logStep("Check That Comment For Record By User Is Present");
        $vkMyPageForm->isCommentPresent($userId, $postId, $comment);

        parent::logStep("Like The Record");
        $vkMyPageForm->leaveLike($postId);

        parent::logStep("Check That Like Is Present");
        $vkApiUtils->assertLikeIsPresent($userId, $postId);

        parent::logStep("Delete The Record");
        $vkApiUtils->deletePost($userId, $postId);

        parent::logStep("Check That Record Was Removed");
        $vkMyPageForm->assertPostAbsent($postId);
    }
}