<?php
require './client.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $phone = $_POST["phone"];

    $client = new JsonPlaceholderApiClient();
    $user = ['name' => $name, 'email' => $email, 'username' => $username, 'phone' => $phone];
    $addedUser = $client->addPost($user);

    header("Content-Type: application/json");
    echo json_encode($addedUser);
    exit;
}