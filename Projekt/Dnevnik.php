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

function izpis_dnevnik()
{
    global $username;
	global $db;

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
</head>
<body>
    <?php echo izpis_dnevnik(); ?>
</body>
</html>