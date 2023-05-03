<html>

<head>
    <meta charset="utf8">
    <title>Registracija, prijava</title>
</head>

<body>

    <?php
    function sifriraj($cistopis)
    {
        $sol = "asdfčoet67jr&h#%/54rJK{#jf/dS+456e57i#5z/(7E7\"w* dDdfg";

        $posoljeno = $cistopis . $sol;
        $sifrirano = hash('sha256', $posoljeno);

        return $sifrirano;
    }

    $mysql_host = "localhost";
    $mysql_user = "root";
    $mysql_password = "";
    $mysql_db = "moodapp";

    $db = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_db);


    function registerUser($db, $username, $password)
    {
        $query = $db->query("SELECT id FROM uporabnik where username='" . $username . "'");
        if ($query->num_rows > 0) {

            return "Uporabniško ime ni več na voljo";
        } else {
            $db->query("INSERT INTO uporabnik (username, pass) VALUES ('" . $username . "', '" . sifriraj($password) . "')");
            return "Registracija uspešna";
        }
    }


    //prijava na stran
    
    function loginUser($db, $username, $password)
    {
        $query = $db->query("SELECT id FROM uporabnik where username='" . $username . "' AND pass='" . sifriraj($password) . "'");
        if ($query->num_rows > 0) {

            // uporabnik obstaja, nastavis cookie, gres na homepage
            $result = $query->fetch_assoc();
            setcookie('uid', $result['id'], time() + 3600);
            header('location: test.php');
        } else {
            return "Uporabniško ime ali geslo ni pravilno";
        }
    }

    if (isset($_POST['reg_username']) && $_POST['reg_pass'] != '') {
        echo registerUser($db, $_POST['reg_username'], $_POST['reg_pass']);
    } else if (isset($_POST['prij_username']) && $_POST['prij_username'] != '') {
        echo loginUser($db, $_POST['prij_username'], $_POST['prij_pass']);
    } else {
        // display registration and login forms
    
    }


    function logoutUser()
    {
        setcookie('uid', '', time() - 3600); // zbrisemo cookie (je že expired)
        header('Location: login_page.php');
        exit();
    }

    ?>

    <h1>Registracija</h1>

    <form action="seenprimer.php" method="post">

        Uporabniško ime: <input type="text" name="reg_username"><br>
        Geslo: <input type="password" name="reg_pass"><br>

        <input type="submit" value="Registriraj se">

    </form>
    <hr>
    <h1>Prijava</h1>

    <form action="seenprimer.php" method="post">

        Uporabniško ime: <input type="text" name="prij_username"><br>
        Geslo: <input type="password" name="prij_pass"><br>
        <input type="submit" value="Prijavi se">

    </form>