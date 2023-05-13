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
 
// SQL query za izbiro podatkov iz bp
switch ($month) {
    case "1":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=1
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "2":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=2
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "3":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=3
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "4":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=4
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "5":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=5
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "6":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=6
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "7":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=7
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "8":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=8
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "9":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=9
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "10":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=10
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "11":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=11
        GROUP BY mood_types_id
        ORDER BY mood_types_id DESC ";
        break;
    case "12":
        $sql = " SELECT mood_types_id, COUNT(*) AS count
        FROM user_mood
        WHERE MONTH(user_mood_date)=12
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
   

            </tr>
            <!-- PHP koda za fetchanje podatkov iz vrstic -->
            <?php
           
                // ZANKA
                while($rows=$result->fetch_assoc())
                {
            ?>
            <tr>
                <!-- PRIDOBIVANJE PODATKOV IZ VSAKEGA
                    VSAKE VRSTICE VSAKEGA STOLPCA -->
                    <td><?php echo $rows['count'];?></td>
                    <td><?php echo $rows['mood_types_id'];?></td>

                
            </tr>
            <?php
                }
            ?>
            
        </table>
        
    </section>


<!DOCTYPE html>
<html>
  <head>
    <title>Stolpični diagram</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  </head>
  <body>
    <canvas id="diagram" style="width:100%;max-width:600px" ></canvas>
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
      var barColors = ["pink", "violet","blue","green","black"];
      var options = {
        legend: { display: false },
        title: {
          display: true,
          text: "Mood Types Count"
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

      new Chart("diagram", {
        type: "bar",
        data: data,
        options: options
      });
    </script>
  </body>
</html>

</body>
 
</html>
