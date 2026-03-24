<?php
    session_start();

    if(!isset($_SESSION['licznik'])){
        $_SESSION['licznik'] = 0;
    }
    $_SESSION['licznik']++;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['wiersze']) and isset($_GET['kolumny']) and isset($_GET['tlo'])){

            $wiersz = $_GET['wiersze'];
            $kolumna = $_GET['kolumny'];
            $tlo = $_GET['tlo'];

            setcookie('wiersze', $wiersz, time()+3600);
            setcookie('kolumny', $kolumna, time()+3600);
            setcookie('tlo', $tlo, time()+3600);

            $_COOKIE['wiersze'] = $wiersz;
            $_COOKIE['kolumny'] = $kolumna;
            $_COOKIE['tlo'] = $tlo;
        }
    }

    $wiersz = $_COOKIE['wiersze'] ?? 10;
    $kolumna = $_COOKIE['kolumny'] ?? 10;
    $tlo = $_COOKIE['tlo'] ?? 'white';

    if(isset($_GET['resetCookies'])){
        setcookie('wiersze', '', time()-3600);
        setcookie('kolumny', '', time()-3600);
        setcookie('tlo', '', time()-3600);

        unset($_COOKIE['wiersze']);
        unset($_COOKIE['kolumny']);
        unset($_COOKIE['tlo']);
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zadanie z sesji i ciasteczek</title>
    <style>
        form{
            display: flex;
            flex-direction: column;
            margin-bottom: 50px;
        }

        form input, form label, form button {
            width: 25%;
        }

        table td{
            padding: 5px;
        }

        form input {
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <form action="index.php" method="get">
        <label for="wiersze">Liczba wierszy</label>
        <input type="number" id="wiersze" name="wiersze" value="<?php echo $wiersz ?>">

        <label for="kolumny">Liczba kolumn</label>
        <input type="number" id="kolumny" name="kolumny" value="<?php echo $kolumna ?>">

        <label for="tlo">Tło (wpisuj nazwy kolorow po angielsku): </label>
        <input type="text" id="tlo" name="tlo" value="<?php echo $tlo ?>">

        <button type="submit">Wyślij</button>
    </form>

    <table border="1" style="background-color: <?php echo $tlo; ?>">
        <?php 
            for($i = 1; $i <= $wiersz; $i++){
                echo "<tr>";
                    echo"<th> $i </th>";
                    for($j = 1; $j <= $kolumna; $j++){
                        $result = $i * $j;
                        echo"<td> $result </td>";
                    }
                echo "</tr>";
            }
        ?>
    </table>

    <form action="index.php" method="get">
        <button type="submit" name="resetCookies">ZRESTARTUJ COOKIES</button>
    </form>

    <p>
        Odwiedziłeś tę stronę już <?php echo $_SESSION['licznik'] ?> razy!
    </p>

</body>
</html>