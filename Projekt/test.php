<?php
    include 'Calendar.php';
	include 'FileSystem.php';

	$file = new FileSystem();

	$currMonth = intval($file->ReadFile($file->monthPrefix));
	$currYear = intval($file->ReadFile($file->yearPrefix));
	if ($currMonth != null || $currYear != null)
	{
		$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
	}
	else
	{
		$calendar = new Calendar();
		$file->WriteFile(intval($calendar->active_month), intval($calendar->active_year));
	}

	if(isset($_POST['previousMonth'])) 
	{
		$currMonth = intval($file->ReadFile($file->monthPrefix));
		$currYear = intval($file->ReadFile($file->yearPrefix));

		if ($currMonth <= 1)
		{
			$currMonth = 12;
			$currYear -= 1;
			$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
			$file->WriteFile($currMonth, $currYear);
		}
		else
		{
			$currMonth -= 1;
			$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
			$file->WriteFile($currMonth, $currYear);
		}
	}
	else if(isset($_POST['nextMonth'])) 
	{
		$currMonth = intval($file->ReadFile($file->monthPrefix));
		$currYear = intval($file->ReadFile($file->yearPrefix));
		
		if ($currMonth >= 12)
		{
			$currMonth = 1;
			$currYear += 1;
			$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
			$file->WriteFile($currMonth, $currYear);
		}
		else
		{
			$currMonth += 1;
			$calendar = new Calendar($currYear . "-" . $currMonth . "-01");
			$file->WriteFile($currMonth, $currYear);
		}		
	}

	/*
	/ Displays added event
	*/
	if (isset($_GET['emotion']))
	{
		if (isset($_GET['color']))
		{
			if (isset($_GET['days']))
			{
				$currMonth = intval($file->ReadFile($file->monthPrefix));
				$currYear = intval($file->ReadFile($file->yearPrefix));
				$date = $currYear . "-" . $currMonth . "-" . $_GET['days'];
				$calendar->add_event($_GET['emotion'], $date, 1, $_GET['color']);
			}	
		}			
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Emotion Calendar</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="CalendarStyle.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	    <nav class="navtop">
	    	<div>
	    		<h1>Emotion Calendar</h1>
	    	</div>
	    </nav>
		<div class="content home">
			<?=$calendar?>
			<hr>
			<form method="post">
				<input type="submit" name="previousMonth"
						value="Previous Month"/>
				
				<input type="submit" name="nextMonth"
						value="Next Month"/>
    		</form>
			<hr>
			<form method="get">
				Enter the desired emotion: <input type="text" name="emotion"><br>
				Select the desired color to display: <select name="color"><br>
					<option value="red">Red</option>
					<option value="blue">Blue</option>
					<option value="green">Green</option>
				</select><br>
				Select the desired day: <select name="days">
					<?php echo $calendar->GetNumOfDays(intval($file->ReadFile($file->monthPrefix))); ?>
				</select><br>
				<br><input type="submit" value="Add Emotion"><br><br>
			</form>
		</div>		
	</body>
</html>