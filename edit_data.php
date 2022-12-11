<?php 
    $pagename = "Edytowanie krotek"; 
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
        
        <h1>Edytuj krotkę</h1>
        <?php 
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            $result = $conn->query("SELECT * FROM ".$_SESSION['table']." WHERE id=".$_SESSION["chosen-row"]);

            $passed_id = false;
            
            while ($row = $result->fetch_assoc()) 
            {
                echo "<tr>";
                foreach ($row as $field => $value)
                 {
                    if(!$passed_id) 
                    {
                        $passed_id = true;
                        continue;
                    }

                    echo '<input type="text" name="'.$field.'" placeholder="'.$value.'" value="'.$value.'" required><br>';
                }
            }        
        ?>

        <button type="submit" class="button" name="isSubmitted" value="true">Edytuj</button>
    </form>

    <a href="table_data.php" class="redirect-button"><button type="button" class="button">Wróć</button></a>

    <?php
        if(isset($_POST["isSubmitted"]) && $_POST["isSubmitted"] == "true")
         {
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error);

            $result = $conn->query("SELECT * FROM ".$_SESSION['table']." WHERE id=".$_SESSION["chosen-row"]);

            $passed_id = false;

            while($row = $result->fetch_assoc())
             {
                foreach ($row as $field => $value)
                 {
                    if(!$passed_id)
                     {
                        $passed_id = true;
                        continue;
                    }

                    $conn->query("UPDATE ".$_SESSION['table']." SET ".$field."='".$_POST[$field]."' WHERE id=".$_SESSION["chosen-row"]);
                }
            }
            
            mysqli_close($conn);

            header("Location: table_data.php");
        }
    ?>
</div>
</body>
</html>