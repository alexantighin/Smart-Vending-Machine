<?php
session_start();

/* Recunoastere client */
$ipAddress=$_SERVER['REMOTE_ADDR'];     // aflare adresa IP
$macAddr=false;

$arp=`arp -n $ipAddress`;               // apelare arp -n 
$lines=explode("\n", $arp);

foreach($lines as $line)
{
    $cols=preg_split('/\s+/', trim($line));
    if ($cols[0]==$ipAddress)
    {
        $macAddr=$cols[2];              // aflare adresa MAC din arp -n
    }
}

#echo "MAC : $macAddr";                  // afisare adresa MAC

require 'includes/baza_de_date.php';         // conectare la baza de date
$_SESSION['id_utilizator'] = 0;
$sql = "SELECT * FROM utilizatori WHERE mac_utilizator = '$macAddr';";      // verificare daca clientul este inregistrat
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)                                           // client deja inregistrat in baza de date
{
    $row = mysqli_fetch_assoc($result);    
    $_SESSION['id_utilizator'] = $row['id_utilizator'];
    $_SESSION['mac_utilizator'] = $row['mac_utilizator'];            
}
else                                                                        // client nou                                                                       
{
    header("Location: ../inregistrare.php");                                    // redirectionare catre pagina de inregistrare
    exit();
}


/* Aflare indormatii din baza de date despre client */
$id_u = (int)$_SESSION['id_utilizator'];
$sql = "SELECT * FROM detalii_utilizatori WHERE id_utilizator = $id_u;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);    
    $_SESSION['nume_utilizator'] = $row['nume_utilizator'];
    $_SESSION['prenume_utilizator'] = $row['prenume_utilizator'];
    $_SESSION['id_produs'] = $row['id_produs']; //
}
$id_p = (int)$_SESSION['id_produs'];
$sql = "SELECT * FROM produse WHERE id_produs = $id_p;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);    
    $_SESSION['nume_produs'] = $row['nume_produs'];
}


/* Aflare disponibilitate produse */
$sql = "SELECT * FROM produse WHERE id_produs = 1;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);    
    $_SESSION['disponibilitate_produs_1'] = $row['disponibilitate'];
    $_SESSION['RGB_produs_1'] = $row['RGB'];
}
$sql = "SELECT * FROM produse WHERE id_produs = 2;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);    
    $_SESSION['disponibilitate_produs_2'] = $row['disponibilitate'];
    $_SESSION['RGB_produs_2'] = $row['RGB'];
}
$sql = "SELECT * FROM produse WHERE id_produs = 3;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);    
    $_SESSION['disponibilitate_produs_3'] = $row['disponibilitate'];
    $_SESSION['RGB_produs_3'] = $row['RGB'];
}

/* Trimitere email in ca de lipsa disponibilitate */
if($_SESSION['disponibilitate_produs_1']==0)
{
	$destinatar = "alexantighin@gmail.com";
	$subiect = "Smart Vending Machine";
	$mesaj = "Produsul 1, Gel anti-bacterian, nu mai este disponibil.";
	mail($destinatar,$subiect,$mesaj);
}
if($_SESSION['disponibilitate_produs_2']==0)
{
	$destinatar = "alexantighin@gmail.com";
	$subiect = "Smart Vending Machine";
	$mesaj = "Produsul 2, Pachet de servetele, nu mai este disponibil.";
	mail($destinatar,$subiect,$mesaj);
}
if($_SESSION['disponibilitate_produs_3']==0)
{
	$destinatar = "alexantighin@gmail.com";
	$subiect = "Smart Vending Machine";
	$mesaj = "Produsul 3, Masca, nu mai este disponibil.";
	mail($destinatar,$subiect,$mesaj);
}


?>


<!DOCTYPE html>
<html style="background-color: #EEEFF1;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Smart Vending Machine</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700,700i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body id="page-top" style="background-color: #EEEFF1;">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper" style="background-color: #EEEFF1;">
            <div id="content">
                <div class="container-fluid" style="/*position: relative;*//*position: absolute;*//*top: 50%;*//*left: 50%;*//*transform: translate(-50%, -50%);*//*position: absolute;*//*top: 50%;*//*left: 50%;*//*margin-top: -50px;*//*margin-left: -50px;*//*width: 100px;*//*height: 100px;*/">
                    <div class="row text-center justify-content-center align-items-start" style="margin-left: 0px;margin-right: 0px;margin-top: 50px;">
                        <div class="col">
                            <?php
                                echo'
                                    <a href="informatii.php"> <h3 class="text-center text-dark mb-0" style="font-size: 21px;text-align: center;font-family: Roboto, sans-serif;font-weight: bold;">Bine ai revenit, ' . htmlspecialchars($_SESSION['prenume_utilizator']) . ' ' . htmlspecialchars($_SESSION['nume_utilizator']) . '!</h3></a>
                                ';
                            ?>
                        </div>
                    </div>
                    <div class="row text-center justify-content-center align-items-start" style="margin-left: 0px;margin-right: 0px;margin-top: 30px;">
                        <div class="col">
                            <?php
                                echo'
                                    <h3 class="text-center text-dark mb-0" style="font-size: 15px;margin-top: 0px;">Produsul favorit este: ' . htmlspecialchars($_SESSION['nume_produs']) . '</h3>
                                ';
                            ?>
                        </div>
                    </div>
                    
                    <form class="form-user" action="includes/comenzi_butoane.php" method="post">
                        <div class="row text-center justify-content-center align-items-start" style="margin-left: 0px;margin-right: 0px;margin-top: 15px;">
                            <div class="col-md-6 col-xl-3 text-center mb-4" style="height: 146px;width: 316px;margin-bottom: 0px;padding-right: 0px;padding-left: 0px;margin-left: 0px;">
                                
                                <?php
                                    if($_SESSION['disponibilitate_produs_1']>0 && $_SESSION['RGB_produs_1'])
                                    {
                                        echo'<button name="motor1" class="btn btn-primary" type="submit" style="height: 146px;width: 316px;border-radius: 35px;background-image: linear-gradient(to right, rgba(161,32,11,1), rgba(235,45,81,1));box-shadow: 4px 5px 6px rgba(0,0,0,0.16);">
                                    <img src="assets/img/icon_gel-antibacterian_big.png" style="width: 57.87px;height: 100px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                </button>';
                                    }
                                    else
                                    {
                                        echo'<button name="motor1" class="btn btn-primary" type="button" style="height: 146px;width: 316px;border-radius: 35px;background-image: linear-gradient(to right, rgba(103,103,103,1), rgba(168,168,168,1));box-shadow: 4px 5px 6px rgba(0,0,0,0.16);">
                                    <img src="assets/img/icon_gel-antibacterian_big.png" style="width: 57.87px;height: 100px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                </button>';
                                    }
                                ?>
                            </div>
                            <div class="col-md-6 col-xl-3 text-center mb-4" style="height: 146px;width: 316px;margin-bottom: 0px;padding-right: 0px;padding-left: 0px;margin-left: 0px;">
                                
                                <?php
                                    if($_SESSION['disponibilitate_produs_2']>0 && $_SESSION['RGB_produs_2'])
                                    {
                                        echo'<button name="motor2" class="btn btn-primary" type="submit" style="height: 146px;width: 316px;border-radius: 35px;background-image: linear-gradient(to right, rgba(87,48,136,1), rgba(6,150,193,1));box-shadow: 4px 5px 6px rgba(0,0,0,0.16);">
                                    <img src="assets/img/icon_servetele_big.png" style="width: 129.49px;height: 85.67px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                </button>';
                                    }
                                    else
                                    {
                                        echo'<button name="motor2" class="btn btn-primary" type="button" style="height: 146px;width: 316px;border-radius: 35px;background-image: linear-gradient(to right, rgba(103,103,103,1), rgba(168,168,168,1));box-shadow: 4px 5px 6px rgba(0,0,0,0.16);">
                                    <img src="assets/img/icon_servetele_big.png" style="width: 129.49px;height: 85.67px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                </button>';
                                    }
                                ?>
                                
                            </div>
                            <div class="col-md-6 col-xl-3 text-center mb-4" style="height: 146px;width: 316px;margin-bottom: 0px;padding-right: 0px;padding-left: 0px;margin-left: 0px;">
                                
                                
                                <?php
                                    if($_SESSION['disponibilitate_produs_3']>0 && $_SESSION['RGB_produs_3'])
                                    {
                                        echo'<button name="motor3" class="btn btn-primary" type="submit" style="background-image: linear-gradient(to right, rgba(13,119,110,1), rgba(56,239,125,1));height: 146px;width: 316px;border-radius: 35px;box-shadow: 4px 5px 6px rgba(0,0,0,0.16);">
                                    <img src="assets/img/icon_masca_big.png" style="width: 136.37px;height: 100px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                </button>';
                                    }
                                    else
                                    {
                                        echo'<button name="motor3" class="btn btn-primary" type="button" style="background-image: linear-gradient(to right, rgba(103,103,103,1), rgba(168,168,168,1));height: 146px;width: 316px;border-radius: 35px;box-shadow: 4px 5px 6px rgba(0,0,0,0.16);">
                                    <img src="assets/img/icon_masca_big.png" style="width: 136.37px;height: 100px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                </button>';
                                    }
                                ?>
                                
                               
                                
                                
                                
                                
                            </div>
                        </div>
                    </form>
                    
                    
                    
                    <?php
                        if($_SESSION['id_utilizator'] == 1)
                        {
                            echo'
                                <form class="form-admin" action="includes/comenzi_butoane.php" method="post">

                                    <div class="row text-center justify-content-center align-items-start" style="margin-left: 0px;margin-right: 0px;margin-top: 15px;">
                                        <div class="col-md-6 col-xl-3 text-center align-self-center mb-4" style="height: 318px;width: 316px;margin-bottom: 0px;padding-right: 0px;padding-left: 0px;margin-left: 0px;">
                                            <div class="text-center" style="background-color: rgb(255,255,255);height: 318px;width: 316px;border-radius: 35px;box-shadow: 4px 5px 6px rgba(0,0,0,0.16);margin: 0 auto;border-right: .50rem solid #707070!important;border-left: .50rem solid #707070!important;border-top: .50rem solid #707070!important;border-bottom: .50rem solid #707070!important;">
                                                <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 45px;border-radius: 10px;margin-top: 20px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-bottom: 5px;">
                                                    <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                                    <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                        <img src="assets/img/icon_gel-antibacterian_small.png" style="width: 24.31px;height: 42px;">
                                                    </div>
                                                    <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                                </div>

                                                <div class="row align-items-center no-gutters" style="background-color: #5a5a5a;width: 260px;height: 58px;border-radius: 15px;margin-top: 0px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-right: 0px;position: absolute;/*top: 50%;*/left: 50%;transform: translate(-50%, 0%);">
                                                    <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                        <button name="motor1_inv" class="btn btn-primary buton_birou_up" id="buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                            <img src="assets/img/replay-1.png">
                                                        </button>
                                                    </div>
                                                    <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                        <button name="motor1_plus" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                            <img src="assets/img/add.png">
                                                        </button>
                                                    </div>
                                                    <div class="col">
                                                        <button name="motor1_minus" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                            <img src="assets/img/minus.png">
                                                        </button>
                                                    </div>
                                                    <div class="col">
                                                        <button name="motor1_clock" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                            <img src="assets/img/replay.png">
                                                        </button>
                                                    </div>
                                                </div>


                                                <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 20px;border-radius: 10px;margin-top: 75px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-bottom: 0px;">                
                                                    <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">                    
                                                        <h3 class="text-center text-dark mb-0" style="font-size: 15px;margin-top: 0px;">Produse disponibile: ' . htmlspecialchars($_SESSION['disponibilitate_produs_1']) . '</h3>
                                                    </div>
                                                </div>


                                                <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 45px;border-radius: 10px;margin-top: 15px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;">
                                                    <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                                    <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">';
                                                        if($_SESSION['disponibilitate_produs_1']>0 && $_SESSION['RGB_produs_1'])
                                                        {
                                                            echo '<button name="motor1_off"class="btn btn-primary" type="submit" style="width: 100px;height: 100px;text-align: center;text-decoration: none;outline: none;color: #fff;background-color: #ffffff;border: .01rem solid #ECEDFB;border-radius: 50%;box-shadow: 1px 3px 6px -1px rgba(228,32,0,1);">
                                                                <img src="assets/img/turn-off.png" style="width: 27px;height: 30px;">
                                                            </button>';
                                                        }
                                                        else
                                                        {
                                                            echo'
                                                            <button name="motor1_off"class="btn btn-primary" type="submit" style="width: 100px;height: 100px;text-align: center;text-decoration: none;outline: none;color: #fff;background-color: #ffffff;border: .01rem solid #ECEDFB;border-radius: 50%;box-shadow: 1px 3px 6px -1px rgba(103,103,103,1);">
                                                                <img src="assets/img/turn-off.png" style="width: 27px;height: 30px;">
                                                            </button>';
                                                        }
                                                    echo'
                                                            
                                                    </div>
                                                    <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>


                                    <div class="col-md-6 col-xl-3 text-center align-self-center mb-4" style="height: 318px;width: 316px;margin-bottom: 0px;padding-right: 0px;padding-left: 0px;margin-left: 0px;">
                                        <div class="text-center" style="background-color: rgb(255,255,255);height: 318px;width: 316px;border-radius: 35px;box-shadow: 4px 5px 6px rgba(0,0,0,0.16);margin: 0 auto;border-right: .50rem solid #707070!important;border-left: .50rem solid #707070!important;border-top: .50rem solid #707070!important;border-bottom: .50rem solid #707070!important;">
                                            <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 45px;border-radius: 10px;margin-top: 20px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-bottom: 5px;">
                                                <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                                <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                    <img src="assets/img/icon_servetele_small.png" style="width: 56.12px;height: 37px;">
                                                </div>
                                                <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                            </div>

                                            <div class="row align-items-center no-gutters" style="background-color: #5a5a5a;width: 260px;height: 58px;border-radius: 15px;margin-top: 0px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-right: 0px;position: absolute;/*top: 50%;*/left: 50%;transform: translate(-50%, 0%);">
                                                <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                    <button name="motor2_inv" class="btn btn-primary buton_birou_up" id="buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                        <img src="assets/img/replay-1.png">
                                                    </button>
                                                </div>
                                                <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                    <button name="motor2_plus" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                        <img src="assets/img/add.png">
                                                    </button>
                                                </div>
                                                <div class="col">
                                                    <button name="motor2_minus" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                        <img src="assets/img/minus.png">
                                                    </button>
                                                </div>
                                                <div class="col">
                                                    <button name="motor2_clock" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                        <img src="assets/img/replay.png">
                                                    </button>
                                                </div>
                                            </div>

                                        <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 20px;border-radius: 10px;margin-top: 75px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-bottom: 0px;">
                                            <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                <h3 class="text-center text-dark mb-0" style="font-size: 15px;margin-top: 0px;">Produse disponibile: ' . htmlspecialchars($_SESSION['disponibilitate_produs_2']) . '</h3>
                                            </div>
                                        </div>

                                        <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 45px;border-radius: 10px;margin-top: 15px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;">
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                            <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">';
                            
                                                if($_SESSION['disponibilitate_produs_2']>0 && $_SESSION['RGB_produs_2'])
                                                        {
                                                            echo '<button name="motor2_off" class="btn btn-primary" type="submit" style="width: 100px;height: 100px;text-align: center;text-decoration: none;outline: none;color: #fff;background-color: #ffffff;border: .01rem solid #ECEDFB;border-radius: 50%;box-shadow: 1px 3px 6px -1px rgba(0,174,231,1);">
                                                    <img src="assets/img/turn-off.png" style="width: 27px;height: 30px;">
                                                </button>';
                                                        }
                                                        else
                                                        {
                                                            echo'
                                                            <button name="motor2_off" class="btn btn-primary" type="submit" style="width: 100px;height: 100px;text-align: center;text-decoration: none;outline: none;color: #fff;background-color: #ffffff;border: .01rem solid #ECEDFB;border-radius: 50%;box-shadow: 1px 3px 6px -1px rgba(103,103,103,1);">
                                                    <img src="assets/img/turn-off.png" style="width: 27px;height: 30px;">
                                                </button>';
                                                        }
                                                    echo'
                            
                            
                                              
                                            </div>
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-6 col-xl-3 text-center align-self-center mb-4" style="height: 318px;width: 316px;margin-bottom: 0px;padding-right: 0px;padding-left: 0px;margin-left: 0px;">
                                    <div class="text-center" style="background-color: rgb(255,255,255);height: 318px;width: 316px;border-radius: 35px;box-shadow: 4px 5px 6px rgba(0,0,0,0.16);margin: 0 auto;border-right: .50rem solid #707070!important;border-left: .50rem solid #707070!important;border-top: .50rem solid #707070!important;border-bottom: .50rem solid #707070!important;">
                                        <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 45px;border-radius: 10px;margin-top: 20px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-bottom: 5px;">
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                            <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                <img src="assets/img/icon_masca_small.png" style="width: 57.27px;height: 42px;">
                                            </div>
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                        </div>
                                        <div class="row align-items-center no-gutters" style="background-color: #5a5a5a;width: 260px;height: 58px;border-radius: 15px;margin-top: 0px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-right: 0px;position: absolute;/*top: 50%;*/left: 50%;transform: translate(-50%, 0%);">
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                <button name="motor3_inv" class="btn btn-primary buton_birou_up" id="buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                    <img src="assets/img/replay-1.png">
                                                </button>
                                            </div>
                                        <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                            <button name="motor3_plus" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                <img src="assets/img/add.png">
                                            </button>
                                        </div>
                                        <div class="col">
                                            <button name="motor3_minus" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                <img src="assets/img/minus.png">
                                            </button>
                                        </div>
                                        <div class="col">
                                            <button name="motor3_clock" class="btn btn-primary buton_birou_up" type="submit" style="font-size: 15px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;width: 48px;height: 48px;background-color: #FFFFFF;border-color: #5A5A5A;border-radius: 50%;outline: 0;margin-left: 0px;font-family: Roboto, sans-serif;">
                                                <img src="assets/img/replay.png">
                                            </button>
                                            </div>
                                        </div>

                                        <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 20px;border-radius: 10px;margin-top: 75px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;margin-bottom: 0px;">
                                            <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">
                                                <h3 class="text-center text-dark mb-0" style="font-size: 15px;margin-top: 0px;">Produse disponibile: ' . htmlspecialchars($_SESSION['disponibilitate_produs_3']) . '</h3>
                                            </div>
                                        </div>

                                        <div class="row align-items-center no-gutters" style="background-color: transparent;width: 300px;height: 45px;border-radius: 10px;margin-top: 15px;text-align: center;padding-left: 10px;padding-right: 10px;margin-left: 0px;">
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                            <div class="col text-center align-self-center" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;">';
                            
                            
                            
                                                if($_SESSION['disponibilitate_produs_3']>0 && $_SESSION['RGB_produs_3'])
                                                        {
                                                            echo '<button name="motor3_off" class="btn btn-primary" type="submit" style="width: 100px;height: 100px;text-align: center;text-decoration: none;outline: none;color: #fff;background-color: #ffffff;border: .01rem solid #ECEDFB;border-radius: 50%;box-shadow: 1px 3px 6px -1px rgba(43,180,94,1);">
                                                    <img src="assets/img/turn-off.png" style="width: 27px;height: 30px;">
                                                </button>';
                                                        }
                                                        else
                                                        {
                                                            echo'
                                                            <button name="motor3_off" class="btn btn-primary" type="submit" style="width: 100px;height: 100px;text-align: center;text-decoration: none;outline: none;color: #fff;background-color: #ffffff;border: .01rem solid #ECEDFB;border-radius: 50%;box-shadow: 1px 3px 6px -1px rgba(103,103,103,1);">
                                                    <img src="assets/img/turn-off.png" style="width: 27px;height: 30px;">
                                                </button>';
                                                        }
                                                    echo'
                                            </div>
                                            <div class="col" style="padding-left: 0px;width: 48px;height: 48px;margin-right: 0px;margin-left: 0px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    ';
                }
            ?>
        </div>
                
    <footer class="text-center" style="position: absolute;bottom: 0;width: 100%;height: 2.5rem;">
        <span style="font-size: 11px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
            <br>© Antighin Alexandru - Andrei<br>
        </span>
    </footer>
                
    </div>
    </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>