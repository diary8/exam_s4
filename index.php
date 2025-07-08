<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/loginstyle.css" />
</head>

<body>
  <div class="form-container">
    <form id="login-form">
      <h3>login form</h3>
      <div class="input">
        <label for="email">email :</label>
        <input type="text" name="email" id="email">
      </div>
      <div class="input">
        <label for="password">password</label>
        <input type="text" name="password" id="password">
      </div>
      <div class="action">
        <button type="submit">se connecter</button>
      </div>
    </form>
  </div>
</body>

</html>
<script>
  const apiBase = "http://localhost/exam_s4/ws";

  const loginForm = document.getElementById("login-form");

  loginForm.addEventListener("submit", function(event) {
    event.preventDefault();

    const userEmail = document.getElementById("email").value.trim();
    const userPassword = document.getElementById("password").value.trim();

    fetch(`${apiBase}/utilisateur/login`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          email: userEmail,
          password: userPassword
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          console.log("connexion réussi");
          window.location.href = "pages/dashboard.php";
        } else {
          console.log("erreur de connexion");
        }
      })
      .catch(error => {
        console.error("Erreur lors de la requête :", error);
      });
  });
</script>