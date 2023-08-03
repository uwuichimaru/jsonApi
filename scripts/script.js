const deleteUser = (userId) => {
  if (confirm("Are you sure you want to delete this user?")) {
    fetch("../php/delete_post.php?postId=" + userId, {
      method: "GET",
    })
      .then((response) => {
        if (response.ok) {
          const listItem = document.getElementById("user-" + userId);
          if (listItem) {
            listItem.remove();
          }
          alert("User deleted successfully!");
        } else {
          alert("Failed to delete user.");
        }
      })
      .catch((error) => {
        console.error("Error occurred while deleting user:", error);
        alert("An error occurred while deleting user.");
      });
  }
};
const userHTML = (userId, name, email, username, phone) => `
  <li id="user-${userId}">
    <strong>User ID:</strong> ${userId}<br>
    <strong>Name:</strong> ${name}<br>
    <strong>Email:</strong> ${email}<br>
    <strong>Username:</strong> ${username}<br>
    <strong>Phone:</strong> ${phone}<br>
    <div class="btn-group">
      <a href="edit_user.php?userId=${userId}" class="btn">Edit</a>
      <a href="#" class="btn btn-delete" onclick="deleteUser(${userId})">Delete</a>
    </div>
  </li>`;

const addUser = () => {
  if (confirm("Add this user?")) {
    const form = document.getElementById("addUserForm");
    const formData = new FormData(form);
    fetch("../php/add_user.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error(
            "Failed to add user. Server responded with status: " +
              response.status
          );
        }
      })
      .then((user) => {
        alert("User added successfully!");
        const listItem = document.createElement("li");
        listItem.innerHTML = userHTML(
          user.id,
          user.name,
          user.email,
          user.username,
          user.phone
        );
        const userList = document.querySelector("ul");
        userList.appendChild(listItem);
        form.reset();
        const users = JSON.parse(localStorage.getItem("users")) || [];
        users.push(user);
        localStorage.setItem("users", JSON.stringify(users));
      })
      .catch((error) => {
        console.error("Error occurred while adding user:", error);
        alert("An error occurred while adding user: " + error.message);
      });
  }
};

const form = document.getElementById("addUserForm");
form.addEventListener("submit", function (event) {
  event.preventDefault();
  addUser();
});
