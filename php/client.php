<?php

class JsonPlaceholderApiClient
{
    private const BASE_URL = 'https://jsonplaceholder.typicode.com';
    public function getUsers()
    {
        return $this->sendRequest('/users');
    }
    public function getUser($userId)
    {
        return $this->sendRequest("/users/{$userId}");
    }
    public function addPost($post)
    {
        $url = self::BASE_URL . '/users';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201) {
            $createdUser = json_decode($response, true);
            $createdUser['id'];
            return $createdUser;
        } else return null;
    }
    public function updateUser($userId, $name, $email, $username, $phone)
    {
        $user = [
            'id' => $userId,
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'phone' => $phone
        ];
        return ['success' => true, 'message' => "User with ID {$userId} has been updated.", 'user' => $user];
    }

    public function updatePost($postId, $updatedData)
    {
        $updatedData['id'] = $postId;
        return $updatedData;
    }

    public function deletePost($postId)
    {
        $url = self::BASE_URL . "/posts/{$postId}";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode === 200) {
            return ['success' => true, 'message' => "Post with ID {$postId} has been deleted."];
        } else
            return ['success' => false, 'message' => "Failed to delete post with ID {$postId}."];
    }
    private function sendRequest($endpoint)
    {
        $url = self::BASE_URL . $endpoint;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }
}