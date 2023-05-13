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
        // preverimo, ali je uporabniško ime veljavno, npr. preverite, ali obstaja v bazi podatkov
    } else {
        echo "Piškotka nima";
        // če piškotka ni, uporabnik ni prijavljen
    }

    $userFound = false;
    $userFound = mysqli_query($db, "SELECT user_id FROM users WHERE username = '$username'");
    while ($user = mysqli_fetch_assoc($userFound))
    if ($username === $user["user_id"]) 
    {
        break;
    }
        
    $sql = " SELECT mood_types.mood_name, diary.diary, user_mood.user_mood_date
    FROM diary
    INNER JOIN user_mood ON diary.user_mood_id = user_mood.user_mood_id
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    ";
    $result = $db->query($sql);
    $db->close();


    while($rows=$result->fetch_assoc()) {
?>
            
        <tr>
            <td><?php echo $rows['user_mood_date'];?></td>
            <td><?php echo $rows['diary'];?></td>
            <td><?php echo $rows['mood_name'];?></td>

        </tr>
<?php
    }
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
            border: 1px solid black;
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

        <table>
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