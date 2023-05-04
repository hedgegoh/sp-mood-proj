<!DOCTYPE html>
<html>

<head>
    <meta charset="utf8">
    <title>Homepage</title>
</head>

<body>
    <h1>Homepage</h1>
    <p>Uspešno si prijavljen_a v Moodapp.</p>
    <h1>Odjava</h1>
    <form action="login_page.php" method="post">
        <input type="submit" value="Izpiši se" name="logout">
    </form>
    <?php
    if (isset($_POST['logout'])) {
        logoutUser();
    }
    ?>
</body>

</html>