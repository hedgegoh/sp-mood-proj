<?php
include 'Calendar.php';
include 'FileSystem.php';

$file = new FileSystem();

$currMonth = intval($file->ReadFile($file->monthPrefix));
$currYear = intval($file->ReadFile($file->yearPrefix));
if ($currMonth != null || $currYear != null) {
	$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
} else {
	$calendar = new Calendar();
	$file->WriteFile(intval($calendar->active_month), intval($calendar->active_year));
}

if (isset($_POST['previousMonth'])) {
	$currMonth = intval($file->ReadFile($file->monthPrefix));
	$currYear = intval($file->ReadFile($file->yearPrefix));

	if ($currMonth <= 1) {
		$currMonth = 12;
		$currYear -= 1;
		$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
		$file->WriteFile($currMonth, $currYear);
	} else {
		$currMonth -= 1;
		$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
		$file->WriteFile($currMonth, $currYear);
	}
} else if (isset($_POST['nextMonth'])) {
	$currMonth = intval($file->ReadFile($file->monthPrefix));
	$currYear = intval($file->ReadFile($file->yearPrefix));

	if ($currMonth >= 12) {
		$currMonth = 1;
		$currYear += 1;
		$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
		$file->WriteFile($currMonth, $currYear);
	} else {
		$currMonth += 1;
		$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
		$file->WriteFile($currMonth, $currYear);
	}
}

/*
/ Displays added event
*/
if (isset($_GET['emotion'])) {
	if (isset($_GET['color'])) {
		if (isset($_GET['days'])) {
			$currMonth = intval($file->ReadFile($file->monthPrefix));
			$currYear = intval($file->ReadFile($file->yearPrefix));
			$date = $currYear . "-" . $currMonth . "-" . $_GET['days'];
			$calendar->add_event($_GET['emotion'], $date, 1, $_GET['color']);
		}
	}
}
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
//funkcija za zapis v tabelo user_mood
function zapis_custva()
{
	//spremenljivke, ki jih bomo rabili
	global $date;
	global $username;
	global $db;


	//spremenljivki za sklicevanje na bazo za čustva in za userja 
	$custvo_v_bazi = "SELECT mood_types_id, mood_name FROM mood_types";
	$user_v_bazi = "SELECT user_id, username FROM uporabnik";

	//sklicevanje na bazo in na postopek v bazi 
	$najdi_userja = mysqli_query($db, $user_v_bazi);

	//While, kjer iz piškotka dobimo id od userja, da lahko to zapišemo v bazo
//sklkicevanje na določeni podatek v bazi userja 
	while ($klic_na_userja = mysqli_fetch_assoc($najdi_userja)) {
		if ($username === $klic_na_userja["user_id"]) {
			break;
			//neha z while, ko najde pravi username iz katerega dobi id 
		}
	}

	//naredi povezavo z bazo in tabelo, dela isto kot najdi_userja 
	$najdi_custvo = mysqli_query($db, $custvo_v_bazi);

	//ko najde čustvo v bazi, ga izpiše
	if (mysqli_num_rows($najdi_custvo) > 0) {
		//klic_na_custvo dela enanko kot klic_na_userja
		while ($klic_na_custvo = mysqli_fetch_assoc($najdi_custvo)) {

			//pogleda, če je v bazi to čustvo
			if ($_GET['emotion'] === $klic_na_custvo["mood_name"]) {
				//vpiše čustvo v bazo
				$db->query("INSERT INTO user_mood (user_id, mood_types_id, user_mood_date) VALUES ('" . $username . "', '" . $klic_na_custvo["mood_types_id"] . "','" . $date . "')");
				break;
				// while se ustavi, ko najde pravo čustvo in ga zapiše v pravo tabelo
			}
		}
	}
}

//funkcija za dnevni citat

function daily_quote()
{
	global $db;
	$izberi_quote = "SELECT quote FROM daily_quotes ORDER BY RAND() LIMIT 1";
	$izreban = mysqli_query($db, $izberi_quote);

	if (mysqli_num_rows($izreban) > 0) {
		// Izpiši citat
		while ($quote = mysqli_fetch_assoc($izreban)) {
			echo $quote["quote"];
		}
	} else {
		echo "Danes ni motivacijskega citata, ampak bodi še naprej svoje sonce";
	}
}

function zapis_v_dnevnik()
{
	global $db;
	global $date;
	global $username;

	$db->query("INSERT INTO dnevnik (user_id, user_mood_date, dnevnik) VALUES ('" . $username . "','" . $date . "',  '" . $_GET['dnevnik'] . "')");
}

//preden začnemo, preverimo, če ima piškot, iz katerega bomo dobili username 
if (isset($_COOKIE['uid'])) {
	$username = $_COOKIE['uid'];
	// preverimo, ali je uporabniško ime veljavno, npr. preverite, ali obstaja v bazi podatkov
} else {
	echo "Piškotka nima";
	// če piškotka ni, uporabnik ni prijavljen
}

//Če je že izbrano čustvo se zažene funkcija, drugače ne
if (isset($_GET['emotion']) != '') {
	echo zapis_custva();
}

if (isset($_GET['dnevnik']) != '') {
	echo zapis_v_dnevnik();
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Koledar čustev</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="CalendarStyle.css" rel="stylesheet" type="text/css">


<body>
	<nav class="navtop">
		<div>
			<h1>Koledar čustev</h1>
		</div>
	</nav>
	<div>
		<?= $calendar ?>
		<hr>
		<form method="post">
			<input type="submit" name="previousMonth" value="Prejšnji mesec" />

			<input type="submit" name="nextMonth" value="Naslednji mesec" />
		</form>
		<hr>
		<form method="get">
			Katero čustvo danes prevladuje v tebi:<select name="emotion"><br>
				<option value="Jeza">Jeza</option>
				<option value="Dolgčas">Dolgčas</option>
				<option value="Zaljubljenost">Zaljubljenost</option>
				<option value="Sreča">Sreča</option>
				<option value="Strah">Strah</option>
				<option value="Tesnoba">Tesnoba</option>
				<option value="Veselje">Veselje</option>
				<option value="Žalost">Žalost</option>
			</select><br>
			Katere barve se počutiš danes?<select name="color"><br>
				<option value="red">Rdeča</option>
				<option value="blue">Modra</option>
				<option value="green">Zelena</option>
			</select><br>

			Kako se dejansko počutiš? <br>
			<textarea rows="4" cols="50%" name="dnevnik"> </textarea><br>

			Izberi dan v mesecu: <select name="days">

				<?php echo $calendar->GetNumOfDays(intval($file->ReadFile($file->monthPrefix))); ?>
			</select><br>
			<br><input type="submit" value="Dodaj čustvo" style="background-color: #62929E; color: #fdfdff;">><br><br>
		</form>
	</div>



	<div>
		<form action="login_page.php" method="post">
			<input type="submit" value="Izpiši se" name="logout">
			<br>
			<br>
		</form>
	</div>

	<?php

	if (isset($_POST['logout'])) {
		echo $_POST['username'];
		logoutUser();
	}
	?>
	<!-- vsakič ko se stran refresha se updatea quote -->
	<h2> Dnevni motivacijski citat, samo zate.</h1>
		<?php daily_quote() ?>

		<!DOCTYPE html>
</body>

</html>
</body>

</html>