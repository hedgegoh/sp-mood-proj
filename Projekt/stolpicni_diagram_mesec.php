<?Php


$todo=$_POST['todo'];

if(isset($todo) and $todo=="submit"){

$month=$_POST['month'];


$date_value="$month";



$date_value="$month";


}

?>

<form method=post name=f1 action=''><input type=hidden name=todo value=submit>

<table border="0" cellspacing="0" >

<tr><td  align=left  >   

<select name=month value=''>Izberi mesec</option>
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


<input type=submit value=Submit>
</table>
</form>


<?php
 
$user = 'root';
$password = '';
$database = 'moodapp';
$servername='localhost';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// preverjanje povezave
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
function GETDATA()
{
global $username;


if (isset($_COOKIE['uid'])) {
    $username = $_COOKIE['uid'];
    // preverimo, ali je uporabniško ime veljavno, npr. preverite, ali obstaja v bazi podatkov
} else {
    echo "Piškotka nima";
    // če piškotka ni, uporabnik ni prijavljen
}

$userFound = false;
$userFound = mysqli_query($mysqli, "SELECT user_id FROM users WHERE username = '$username'");
while ($user = mysqli_fetch_assoc($userFound))
if ($username === $user["user_id"]) 
{
    break;
}

// SQL query za izbiro podatkov iz bp
switch ($month) {
    case "1":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=1 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "2":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=2 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "3":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=3 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "4":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=4 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "5":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=5 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "6":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=6 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "7":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=7 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "8":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=8 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "9":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=9 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "10":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=10 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "11":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=11 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "12":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=12 AND user_id = '$username'
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;


}

$result = $mysqli->query($sql);

// podatke v json
$data = array();
while($rows=$result->fetch_assoc()) {
    $data[] = array(
        "label" => $rows["mood_types_id"],
        "value" => $rows["count"]
    );
}
$json_data = json_encode($data);

$mysqli->close();
}

?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <title>MOODAPP podatki</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }
 
        h1 {
            text-align: center;
            color: black;
            font-size: xx-large;
            font-family: 'sans-serif';
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
        <h1>Poročilo za mesec <?php echo $month ?></h1>

        <table id="Tabela">
            <tr>
            <!DOCTYPE html>
<html>
<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Create a canvas element where the chart will be drawn -->
<canvas id="myChart"></canvas>

<script>
// Get the data from the PHP script
let data = <?php echo json_encode(GETDATA()); ?>;

// Create the chart
let ctx = document.getElementById('myChart').getContext('2d');
let chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Sad', 'Happy', 'Angry', 'Neutral'],
    datasets: [{
      label: 'Moods',
      data: data,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>

  </body>
</html>



            </tr>
            
  
            
        </table>
        
    </section>


    
</body>
 
</html>
