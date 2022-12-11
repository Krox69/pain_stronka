<?php 
    $pagename = "Rejestracja"; 
    require("header.php");
?>
<body>
	<div class="delta-container">
		<h1>Zarejestruj się</h1>

		<form action="?" method="post">
			<div class="form-inputs">
				<input type="text" name="username" id="username_input" placeholder="Nazwa użytkownika" required><br>
				<input type="email" name="email" id="email_input" placeholder="Email użytkownika" required><br>
				<input type="text" name="firstname" id="firstname_input" placeholder="Imię" required><br>
				<input type="text" name="lastname" id="lastname_input" placeholder="Nazwisko" required><br>
				<input type="password" name="password" id="password_input" placeholder="Hasło" required><br>
				<input type="password" name="password_confirm" id="password_confirm_input" placeholder="Potwierdź hasło" required><br>
				<button type="submit" class="button" name="isSubmitted" value="true">Zarejestruj się!</button>
			</div>
		</form>

        <form action="login.php">
            <button type="submit" class="button">Zaloguj się</button>
        </form>

		<?php
			if(isset($_POST["isSubmitted"]) && $_POST["isSubmitted"] == "true")
			{
				if($_POST["username"] != "" && $_POST["password"] != "") 
				{
					if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
						echo '<p>Niepoprawny email.</p>';
					else if($_POST["password"] != $_POST["password_confirm"])
						echo '<p>Hasła nie są takie same.</p>';
					else 
					{
						$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

						if ($conn->connect_error)
						die("Connection failed: " . $conn->connect_error);
						
						$username = $_POST["username"];
						$email = $_POST["email"];
						$password = $_POST["password"];
						$firstname = $_POST["firstname"];
						$lastname = $_POST["lastname"];

						$result = $conn->query("SELECT * FROM users WHERE username = '".$username."'");

						if($conn->query("SELECT * FROM users WHERE username = '".$username."'")->num_rows > 0)
						 {
							echo '<p>Podana nazwa użytkownika jest zajęta.</p>';
						}
						else if($conn->query("SELECT * FROM users WHERE email = '".$email."'")->num_rows > 0)
						 {
							echo '<p>Ten email już posiada użytkownika</p>';
						}
						else 
						{
							$hashedPass = password_hash($password, PASSWORD_DEFAULT);

							$conn->query("INSERT INTO users (username, email, userpass, firstname, lastname) 
										  VALUES ('".$username."', '".$email."','".$hashedPass."', '".$firstname."', '".$lastname."')");

							echo '<p>Pomyślnie zarejestrowano użytkownika '.$username;
						}

						mysqli_close($conn);

						header("login.php");
					}
                }
				else
					echo '<p>Musisz wypełnić <b>wszystkie</b> pola</p>';

			}
		?>
	</div>
</body>
</html>
