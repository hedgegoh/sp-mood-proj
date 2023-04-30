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
		$file->WriteFile($calendar->active_month, $calendar->active_year);
	}   
	
    //$calendar->add_event('Veselo', '2023-02-03', 1, 'green');
    //$calendar->add_event('Jezno', '2023-02-04', 1, 'red');
    //$calendar->add_event('Holiday', '2023-02-16', 7);

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
	if(isset($_POST['nextMonth'])) 
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
		</div>		
	</body>
</html>