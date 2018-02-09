<?php

namespace Application\Framework\Utils;

use PHPUnit\Framework\TestCase;

/**
 * Class VkApiUtils
 * @package Application\Framework\Utils
 */
class VkApiUtils
{

    private $apiVersion = '5.71';
    private $accessToken;
    private $requestStartUrl = "https://api.vk.com/method/";

    /**
     * VkApiUtils constructor.
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function getUserInfo()
    {
        $request_params = [];
        $result = $this->executeRequest($request_params, 'users.get');
        return $result->response[0]->id;
    }

    /**
     * @param $message
     * @return mixed
     */
    public function postRecordOnWall($message)
    {
        $request_params = array(
            'message' => $message
        );
        $result = $this->executeRequest($request_params, 'wall.post');
        return $result->response->post_id;
    }

    public function executeRequest($params, $method)
    {
        $request_params = array(
            'v' => $this->apiVersion,
            "access_token" => $this->accessToken
        );
        $result_params = http_build_query(array_merge($request_params, $params));
        $result = json_decode(file_get_contents($this->requestStartUrl . $method . '?' . $result_params));
        return $result;
    }

    public function editRecordWithAttachments($postId, $newMessage, $photoId)
    {
        $request_params = array(
            'attachments' => $photoId
        );
        $this->editRecord($postId, $newMessage, $request_params);
    }

    /**
     * @param $postId
     * @param $newMessage
     * @param array $additionParams
     */
    public function editRecord($postId, $newMessage, $additionParams = [])
    {
        $request_params = array(
            'post_id' => $postId,
            'message' => $newMessage
        );
        $resultRequest = array_merge($request_params, $additionParams);
        $this->executeRequest($resultRequest, 'wall.edit');
    }

    /**
     * @return mixed
     */
    public function saveWallPhoto()
    {
        $request_params = [];
        $result = $this->executeRequest($request_params, 'photos.getWallUploadServer');

        $this_dir = dirname(__FILE__);
        $secondParentDir = realpath($this_dir . '/../..');
        $imagePath = $secondParentDir . '\images\\cat.jpg';

        $cfile = curl_file_create($imagePath, 'image/jpeg', 'cat.jpg');
        $ch = curl_init($result->response->upload_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'photo' => $cfile
        ));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = json_decode(curl_exec($ch));

        $request_params = array(
            "photo" => $result->photo,
            "server" => $result->server,
            "hash" => $result->hash
        );
        $result = $this->executeRequest($request_params, 'photos.saveWallPhoto');
        return $result->response[0]->id;
    }

    public function createComment($postId, $comment)
    {
        $request_params = array(
            'post_id' => $postId,
            'message' => $comment
        );
        $this->executeRequest($request_params, 'wall.createComment');
    }

    public function assertLikeIsPresent($userId, $postId)
    {
        $request_params = array(
            "type" => "post",
            'owner_id' => $userId,
            'item_id' => $postId
        );
        $result = $this->executeRequest($request_params, 'likes.getList');
        $users = $result->response->items;
        TestCase::assertNotNull(array_search($userId, $users), "likes list does not contain userId= " . $userId);
    }

    public function deletePost($userId, $postId)
    {
        $request_params = array(
            'owner_id' => $userId,
            'post_id' => $postId,
        );
        $this->executeRequest($request_params, 'wall.delete');
    }
}




