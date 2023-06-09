<?php
//najprej se ponovno povežemo z bazo 
$mysql_host = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_db = "moodapp";

$db = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);

//pove nam, če je problem s povezavo na bazo
if ($db->connect_errno) {
	die("Failed to connect to MySQL: " . $db->connect_error);
}


?>




<?php
function DobiPodatke()
{
    global $db;
    global $username;
    global $result;

    if (isset($_COOKIE['uid'])) {
        $username = $_COOKIE['uid'];
        // Check if the username is valid, e.g. check if it exists in the database
    } else {
        echo "Cookie not found";
        // If the cookie is not set, the user is not logged in
        return;
    }

    $sql = "SELECT users.user_id, mood_types.mood_name, diary.diary, user_mood.user_mood_date
            FROM diary
            INNER JOIN user_mood ON diary.user_mood_id = user_mood.user_mood_id
            INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
            INNER JOIN users ON user_mood.user_id = users.user_id
            WHERE users.user_id = '$username'";
    $result = $db->query($sql);

    if (!$result) {
        // Print the error message and return without fetching any data.
        printf("Query execution failed: %s\n", $db->error);
        return;
    }

    while($rows=$result->fetch_assoc()) {
?>
            
        <tr>
            <td><?php echo $rows['user_mood_date'];?></td>
            <td><?php echo $rows['diary'];?></td>
            <td><?php echo $rows['mood_name'];?></td>

        </tr>
<?php
    }

    $db->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dnevnik</title>
    <link href="style.css" rel="stylesheet" type="text/css">
 
    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border-collapse: collapse;
        }
 
        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family:'sans-serif';
        }
 
        td {
             border: 1px solid black;
        }
 
        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }


    </style>
</head>

<body>
    <section>
        <h1>DNEVNIK</h1>

        <table id="Tabela">
            <tr>
                <th>datum</th>
                <th>zapis</th>
                <th>mood ime</th>
            </tr>

            <?php DobiPodatke(); ?>
        </table>
    </section>

    
</body>
 
</html>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #04AA6D;
  color: white;
}

.round {
  border-radius: 50%;
}
.logout-gumb {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

</style>
</head>
<body>
<p><button onclick="sortTable()" class= "logout-gumb">KLIKNI, DA RAZVRSTIŠ TABELO PO DATUMU</button></p>
<a href="test.php" class="previous">&laquo; Nazaj na koledar</a>
<a href="stolpicni_diagram_mesec.php" class="next">Naprej na stolpični diagram &raquo;</a>

<form action="login_page.php" method="post">
		<input type="submit" value="Izpiši se" name="logout" class="logout-gumb">
		<br>
		<br>
	</form>

	<?php

	if (isset($_POST['logout'])) {
		echo $_POST['username'];
		logoutUser();
	}
	?>

<script>
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("Tabela");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>

</body>
</html> 
