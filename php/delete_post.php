<?php
require './client.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["postId"])) {
    $postId = $_GET["postId"];
    $client = new JsonPlaceholderApiClient();
    $result = $client->deletePost($postId);

    if ($result['success']) {
        header("Location: ../index.php?success=deleted");
        exit;
    } else {
        header("Location: ../index.php?error=delete_failed");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>
