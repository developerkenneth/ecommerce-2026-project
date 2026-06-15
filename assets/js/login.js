const form = document.querySelector("#login-form");

form.addEventListener("submit", async function (e) {
  e.preventDefault();

  const email = document.querySelector("#email").value;
  const password = document.querySelector("#password").value;

  const response = await fetch(`http://localhost:3000/users?email=${email}`);

  const users = await response.json();

  if (users.length === 0) {
    alert("User not found");
    return;
  }

  const user = users[0];

  if (user.password === password) {
    localStorage.setItem("user", JSON.stringify(user));

    alert("Login successful");

    window.location.href = "index.html";
  } else {
    alert("Incorrect password");
  }
});
