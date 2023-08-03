<!DOCTYPE html>
<html>

<head>
    <title>Simple Item List</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css?<?php echo time(); ?>">
</head>

<body>
    <h1>User List</h1>
    <?php
    require 'php/client.php';
    $client = new JsonPlaceholderApiClient();
    if (isset($_GET['success']) && $_GET['success'] === 'deleted')
        echo '<p class="success-msg">User deleted successfully!</p>';
    $users = $client->getUsers();
    if (!empty($users)) {
        echo '<ul>';
        foreach ($users as $user) {
            $updatedUser = [
                'name' => $_COOKIE["user_{$user->id}[name]"] ?? null,
                'email' => $_COOKIE["user_{$user->id}[email]"] ?? null,
                'username' => $_COOKIE["user_{$user->id}[username]"] ?? null,
                'phone' => $_COOKIE["user_{$user->id}[phone]"] ?? null,
            ];
            echo '<li id="user-' . $user->id . '">';
            echo '<strong>User ID:</strong> ' . $user->id . '<br>';
            echo '<strong>Name:</strong> ' . ($updatedUser['name'] ?? $user->name) . '<br>';
            echo '<strong>Email:</strong> ' . ($updatedUser['email'] ?? $user->email) . '<br>';
            echo '<strong>Username:</strong> ' . ($updatedUser['username'] ?? $user->username) . '<br>';
            echo '<strong>Phone:</strong> ' . ($updatedUser['phone'] ?? $user->phone) . '<br>';
            echo '<div class="btn-group">';
            echo '<a href="#" class="btn btn-delete" onclick="deleteUser(' . $user->id . ')">Delete</a>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No users found.</p>';
    }
    ?>
    <h2>Добавление пользователя</h2>
    <form action="php/add_user.php" method="POST" id="addUserForm">
        <label for="userName">Name</label>
        <input type="text" id="userName" name="name" required>
        <label for="userEmail">Email</label>
        <input type="email" id="userEmail" name="email" required>
        <label for="userUsername">Username</label>
        <input type="text" id="userUsername" name="username" required>
        <label for="userPhone">Phone</label>
        <input type="text" id="userPhone" name="phone" required>
        <button type="submit" class="btn btn-user" id="addUserBtn">Добавить</button>
    </form>
    <script src="scripts/script.js"></script>
</body>

</html>