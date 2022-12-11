<?php 
    $pagename = "Zalogowana"; 
    require("header.php");
?>
<body>
<div class="delta-container">
    <?php

    if(isset($_POST["log-out"]))
     {
        session_destroy();
        header("Location: login.php");
    }

    if(isset($_SESSION["logged-in"]) && $_SESSION["logged-in"])
        echo '
            <h1>Witaj '.($_SESSION["is-admin"] ? 'Administratorze' : 'Użytkowniku').'!</h1>

            <div id="siema" style="text-align: left">
                <p>Nazwa użytkownika: '.$_SESSION["username"].'</p>
                <p>Email użytkownika: '.$_SESSION["email"].'</p>
                <p>Imię użytkownika: '.$_SESSION["firstname"].'</p>
                <p>Nazwisko użytkownika: '.$_SESSION["lastname"].'</p>
                <p>Rola użytkownika: '.$_SESSION["user-role"].'</p>
                <p>Data rejestracji: '.$_SESSION["register_date"].'</p>
            </div>
        
            <form action="?" method="post">
                <button type="submit" class="button" name="log-out" value="true">Wyloguj się</button>
            </form>

            <a href="table_data.php" class="redirect-button"><button type="button" class="button">Popatrz na dane z tabeli</button></a>
        ';

    else 
    {
        echo '
            <h1>Nie jesteś zalogowany!</h1>
            <form action="index.php">
                <button type="submit" class="button">Zarejestruj się</button>
            </form>
            <form action="login.php">
                <button type="submit" class="button">Zaloguj się</button>
            </form>
        ';
    }
    ?>
</div>
</body>
</html>

