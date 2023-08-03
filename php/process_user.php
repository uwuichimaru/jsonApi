<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $body = $_POST["body"];
    require './client.php';
    $client = new JsonPlaceholderApiClient();
    $post = ['title' => $title, 'body' => $body];
    $addedPost = $client->addPost($post);
    header("Location: index.php");
    exit;
}
?>
