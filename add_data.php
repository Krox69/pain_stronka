<?php 
    $pagename = "Dodawanie krotek"; 
    require("header.php");
?>
<body>
<div class="delta-container table-data">

    <?php 
        if(!isset($_POST["chosen-row"]) && !isset($_SESSION["chosen-row"])) 
            header("Location: table_data.php");
        else if(isset($_POST["chosen-row"]))
            $_SESSION["chosen-row"] = $_POST["chosen-row"];
    ?>

    <form action="?" method="post" class="edit-form">
        
        <h1>Dodaj krotkę</h1>
        <h4 style="text-align: center; color: whitesmoke">Puste pole oznacza wartość domyślną lub błąd </h4>
        <?php 
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            $result = $conn->query("SHOW COLUMNS FROM ".$_SESSION['table']);

            $passed_id = false;

            while ($row = $result->fetch_assoc())
             {
                echo "<tr>";
                if(!$passed_id) {
                    $passed_id = true;
                    continue;
                }
                echo '<td><input type="text" name="'.$row['Field'].'" placeholder="'.$row['Field'].'"><br></td>';
            }        
        ?>

        <button type="submit" class="button" name="isSubmitted" value="true">Dodaj</button>
    </form>

    <a href="table_data.php" class="redirect-button"><button type="button" class="button">Wróć</button></a>

    <?php
        if(isset($_POST["isSubmitted"]) && $_POST["isSubmitted"] == "true")
         {
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error);

            $result = $conn->query("SHOW COLUMNS FROM ".$_SESSION['table']);

            $passed_id = false;

            $fields = "(";
            $values = "(";

            while($row = $result->fetch_assoc())
             {
                if(!$passed_id) {
                    $passed_id = true;
                    continue;
                }
                $fields .= $row['Field'].",";

                if(empty($_POST[$row['Field']]))
                 {
                    echo 'yo';
                    $values .= "null,";
                }
                else if(preg_match("/[a-z]/i", $_POST[$row['Field']]))
                    $values .= "'".$_POST[$row['Field']]."',";
                else
                $values .= "".$_POST[$row['Field']].",";
            }

            $fields = rtrim($fields, ",").")";
            $values = rtrim($values, ",").")";

            $conn->query("INSERT INTO ".$_SESSION['table']." ".$fields." VALUES ".$values);
            
            mysqli_close($conn);

            header("Location: table_data.php");
        }
    ?>
</div>
</body>
</html>