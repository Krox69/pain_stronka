<?php 
    $pagename = "Logowanie"; 
    require("header.php");
?>
<body>
<div class="delta-container">
    <h1>Zaloguj się</h1>

    <form action="?" method="post">
        <div class="form-inputs">
            <input type="text" name="username" id="username_input" placeholder="Nazwa użytkownika" required><br>
            <input type="password" name="password" id="password_input" placeholder="Hasło" required><br>
        </div>  
        <button type="submit" class="button" name="isSubmitted" value="true">Zaloguj się!</button required>
    </form>

    <form action="index.php">
        <button type="submit" class="button">Zarejestruj się</button>
    </form>

    <?php
    if(isset($_POST["isSubmitted"]) && $_POST["isSubmitted"] == "true")
     {
        if($_POST["username"] != "" && $_POST["password"] != "")
         {
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error);

            $username = $_POST["username"];
            $password = $_POST["password"];

            $sql = "SELECT * FROM users WHERE username = '" . $username . "'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0)
             {
                $sql = "SELECT userpass FROM users WHERE username = '" . $username . "'";
                $dbPass = $conn->query($sql)->fetch_column(0);

                if(password_verify($password, $dbPass))
                 {
                    $_SESSION["username"] = $username;
                    
                    $_SESSION["email"] = $conn->query("SELECT email FROM users WHERE username = '".$username."'")->fetch_column(0);

                    $_SESSION["firstname"] = $conn->query("SELECT firstname FROM users WHERE username = '".$username."'")->fetch_column(0);

                    $_SESSION["lastname"] = $conn->query("SELECT lastname FROM users WHERE username = '".$username."'")->fetch_column(0);

                    $_SESSION["register_date"] = $conn->query("SELECT register_date FROM users WHERE username = '".$username."'")->fetch_column(0);

                    $_SESSION["user-role"] = $conn->query("SELECT user_role FROM users WHERE username = '".$username."'")->fetch_column(0);
                    
                    $_SESSION["is-admin"] = $_SESSION["user-role"] == "admin";
                    
                    $_SESSION["logged-in"] = true;

                    header("Location: logged-in.php");
                }
                else
                    echo '<p>Złe hasło!</p>';
            }
            else
                echo '<p>Takie konto nie istnieje</p>';

            mysqli_close($conn);
        }
        else
            echo '<p>Musisz wypełnić <b>wszystkie</b> pola</p>';
    }
    ?>
</div>
</body>
</html>
