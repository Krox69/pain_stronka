<?php 
    $pagename = "Tajna stronka"; 
    require("header.php");
?>
<body>
<div class="delta-container table-data">

    <?php 
        if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]) 
            header("Location: logged-in.php");
    ?>

    <form action="?" method="post">
        <h1>Dane z tabeli</h1>
        <?php       
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            $result = $conn->query("SHOW TABLES");

            echo '<div class="form-output-selection">';
            while ($row = $result->fetch_array())
                echo 
                '
                <div class="form-output-checkboxes">
                    <input type="radio" name="table" id="'.$row[0].'" value="'.$row[0].'">
                    <label for="'.$row[0].'">'.$row[0].'</label>
                </div>
                ';
            echo '</div>';
        ?>

        <button type="submit" class="button">Wyświetl tabelę</button>
    </form>

    <?php
        if(isset($_POST['table']) && $_POST['table'] != "")
            $_SESSION['table'] = $_POST['table'];

        if(isset($_POST['table']) || isset($_SESSION['table']))
        {
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error)
                die("Connection failed: " . $conn->connect_error);
            
            $result = $conn->query("SHOW COLUMNS FROM ".$_SESSION['table']);
            
            if ($result->num_rows > 0)
             {
                echo '<form action="?" method="post">';
                echo '<div class="form-output-selection">';

                while($row = $result->fetch_assoc())
                    echo 
                    '
                    <div class="form-output-checkboxes">
                        <input type="checkbox" name="columns[]" id="'.$row['Field'].'" value="'.$row['Field'].'" checked>
                        <label for="'.$row['Field'].'">'.$row['Field'].'</label></br>
                    </div>
                    ';

                echo '</div>';
                echo '<button type="submit" class="button">Wyświetl kolumny</button>';
                echo '</form>';
            } 
            else
                echo "0 results";

            if(isset($_POST['columns']))
             {   
                echo '<div class="output">';
                echo '<h2>'.strtoupper($_SESSION['table']).'</h2>';
            
                $result = $conn->query("SHOW COLUMNS FROM ".$_SESSION['table']);
                
                echo '<form action="edit_data.php" method="post">';
                echo '<table class="output-columns">';

                echo "<tr>";

                while($row = $result->fetch_assoc())
                    echo "<td style='font-weight: bolder'>" . $row['Field'] . "</td>";

                echo "</tr>";

                $result = $conn->query("SELECT * FROM ".$_SESSION['table']);

                while ($row = $result->fetch_assoc())
                 {
                    echo "<tr>";
                    foreach ($row as $field => $value)
                        echo "<td>" . $value . "</td>";
                    
                    echo '<td><button type="submit" class="button edit-button" value="'.$row['id'].'" name="chosen-row">Edytuj</button></td>';
                }

                echo "</tr>";
                echo "</table>";
                echo '<a href="add_data.php" class="redirect-button"><button type="button" class="button">Dodaj krotkę</button></a>';
                echo '</form>';
                echo '</div>';
            }

            mysqli_close($conn);
        }
    ?>

    <a href="logged-in.php" class="redirect-button"><button type="button" class="button">Wróć</button></a>
</div>
</body>
</html>