<?php

if (isset($_POST['todo']) != ""){
    $todo=$_POST['todo'];
    $month = $_POST['month'];
  $date_value = "$month";
} else { 
    $todo = '01';
    $month = '01';
}
?>



<?php
$user = 'root';
$password = 'root';
$database = 'moodapp';
$servername = 'localhost';
$mysqli = new mysqli(
  $servername,
  $user,
  $password,
  $database
);

// preverjanje povezave
if ($mysqli->connect_error) {
  die('Connect Error (' .
    $mysqli->connect_errno . ') ' .
    $mysqli->connect_error);
}

if (isset($_COOKIE['uid'])) {
  $username = $_COOKIE['uid'];
  // preverimo, ali je uporabniško ime veljavno, npr. preverite, ali obstaja v bazi podatkov
} else {
  echo "Piškotka nima";
  // če piškotka ni, uporabnik ni prijavljen
}


// SQL query za izbiro podatkov iz bp



switch ($month) {


  case "1":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 1 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";

      break;
  case "2":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 2 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";

      break;
  case "3":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 3 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "4":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 4 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "5":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 5 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "6":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 6 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "7":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 7 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "8":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 8 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "9":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 9 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "10":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 10 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "11":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 11 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;
  case "12":
    $sql = "SELECT mood_types.mood_types_id, mood_types.mood_name, COUNT(*) AS count
    FROM user_mood
    INNER JOIN mood_types ON user_mood.mood_types_id = mood_types.mood_types_id
    WHERE MONTH(user_mood.user_mood_date) = 12 AND user_mood.user_id = '$username'
    GROUP BY user_mood.mood_types_id
    ORDER BY user_mood.mood_types_id DESC";
      break;


}
$result = $mysqli->query($sql);

// podatke v json
$data = array();
while($rows=$result->fetch_assoc()) {
    $data[] = array(
        "label" => $rows["mood_name"],
        "value" => $rows["count"]
    );
}

$json_data = json_encode($data);
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mesečno poročilo čustev za:
    <?php echo $month ?>
  </title>
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
      font-family: 'sans-serif';
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
    <h1>POROČILO ZA MESEC
      <?php echo $month ?>
    </h1>

    <form method=post name=f1 action=''>
  <input type=hidden name=todo value="submit">
  <table border="0" cellspacing="0">
    <tr>
      <td align=left>
        <select name=month value=''>
          <option value='01'>Januar</option>
          <option value='02'>Februar</option>
          <option value='03'>Marec</option>
          <option value='04'>April</option>
          <option value='05'>Maj</option>
          <option value='06'>Junij</option>
          <option value='07'>Julij</option>
          <option value='08'>Avgust</option>
          <option value='09'>September</option>
          <option value='10'>Oktober</option>
          <option value='11'>November</option>
          <option value='12'>December</option>
        </select>
        <input type=submit value=Izberi>
  </table>
</form>
  </section>
</body>

</html>


<!DOCTYPE html>
<html>

<head>
  <title>Stolpični diagram</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

<body>
  <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
  <script>
    // vzame json podatke iz php
    var jsonData = <?php echo $json_data; ?>;

      // vzame x,y iz json podatkov
      var xValues = jsonData.map(function(item) {
        return item.label;
      });
      var yValues = jsonData.map(function(item) {
        return item.value;
      });

      // izgled
      var barColors = ["pink", "violet","blue","green","yellow"];
      var options = {
        legend: { display: false },
        title: {
          display: true,
          text: "Mood Types / Count"
        }
      };
      var data = {
        labels: xValues,
        datasets: [
          {
            backgroundColor: barColors,
            data: yValues
          }
        ]
      };

      new Chart("myChart", {
        type: "bar",
        data: data,
        options: options
      });
    </script>
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
</style>
</head>
<body>
<br> 
<a href="test.php" class="previous">&laquo; Nazaj na koledar</a> 
<a href="Dnevnik.php" class="next">Naprej na dnevnik &raquo;</a>
<br>
<br>
<form action="login_page.php" method="post">
		<input type="submit" value="Izpiši se" name="logout">
		<br>
		<br>
	</form>

	<?php

	if (isset($_POST['logout'])) {
		echo $_POST['username'];
		logoutUser();
	}
	?>

  
</body>
</html> 
