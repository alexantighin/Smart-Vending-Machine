<?php
session_start();
require 'baza_de_date.php';

/* Butoane Client */
if (isset($_POST['motor1']))  
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs=1; ";
    mysqli_query($conn, $sql);

    exec('sudo python /var/www/arduino/q.py');
    sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_1'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_1'] == 0)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=1;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor1_off.py');
    	}
    }
}
if (isset($_POST['motor2']))  
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs=2; ";
    mysqli_query($conn, $sql);
    
    exec('sudo python /var/www/arduino/a.py');
    sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 2;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_2'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_2'] == 0)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=2;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor2_off.py');
    	}
    }
}
if (isset($_POST['motor3']))  
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs=3; ";
    mysqli_query($conn, $sql);
    
    exec('sudo python /var/www/arduino/z.py');
sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 3;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_3'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_3'] == 0)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=3;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor3_off.py');
    	}
    }
}



/* Butoane Administartor */
if (isset($_POST['motor1_inv'])) 
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs=1; ";
    mysqli_query($conn, $sql);
    exec('sudo python /var/www/arduino/q.py');
    sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_1'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_1'] == 0)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=1;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor1_off.py');
    	}
    }
}

if (isset($_POST['motor1_plus'])) 
{
    exec('sudo python /var/www/arduino/w.py');
}

if (isset($_POST['motor1_minus'])) 
{
    exec('sudo python /var/www/arduino/e.py');
}

if (isset($_POST['motor1_clock'])) 
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate +1 WHERE id_produs=1; ";
    mysqli_query($conn, $sql);
    
    exec('sudo python /var/www/arduino/r.py');
    sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_1'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_1'] == 1)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=1;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor1_on.py');
    	}
    }
}

if (isset($_POST['motor1_off']))
{
    $sql = "SELECT * FROM produse WHERE id_produs = 1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['RGB_produs_1'] = $row['RGB'];
    	if($_SESSION['RGB_produs_1'])
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=1;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor1_off.py');
    	}
	else
	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=1;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor1_on.py');
	}
    }
}


if (isset($_POST['motor2_inv'])) 
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs=2; ";
    mysqli_query($conn, $sql);
    exec('sudo python /var/www/arduino/a.py');
	sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 2;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_2'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_2'] == 0)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=2;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor2_off.py');
    	}
    }
}

if (isset($_POST['motor2_plus']))
{
    exec('sudo python /var/www/arduino/s.py');
}

if (isset($_POST['motor2_minus'])) 
{
    exec('sudo python /var/www/arduino/d.py');
}

if (isset($_POST['motor2_clock']))
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate + 1 WHERE id_produs=2; ";
    mysqli_query($conn, $sql);
    
    exec('sudo python /var/www/arduino/f.py');
sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 2;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_2'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_2'] == 1)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=2;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor2_on.py');
    	}
    }
}

if (isset($_POST['motor2_off']))
{
    $sql = "SELECT * FROM produse WHERE id_produs = 2;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['RGB_produs_2'] = $row['RGB'];
    	if($_SESSION['RGB_produs_2'])
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=2;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor2_off.py');
    	}
	else
	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=2;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor2_on.py');
	}
    }
}



if (isset($_POST['motor3_inv']))
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate - 1 WHERE id_produs=3; ";
    mysqli_query($conn, $sql);
    exec('sudo python /var/www/arduino/z.py');
    sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 3;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_3'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_3'] == 0)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=3;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor3_off.py');
    	}
    }
}

if (isset($_POST['motor3_plus'])) 
{
    exec('sudo python /var/www/arduino/x.py');
}

if (isset($_POST['motor3_minus']))
{
    exec('sudo python /var/www/arduino/c.py');
}

if (isset($_POST['motor3_clock'])) 
{
    $sql = "UPDATE produse SET disponibilitate = disponibilitate + 1 WHERE id_produs=3; ";
    mysqli_query($conn, $sql);
    exec('sudo python /var/www/arduino/v.py');
sleep(3);

    $sql = "SELECT * FROM produse WHERE id_produs = 3;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['disponibilitate_produs_3'] = $row['disponibilitate'];
    	if($_SESSION['disponibilitate_produs_3'] == 1)
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=3;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor3_on.py');
    	}
    }
}

if (isset($_POST['motor3_off']))
{
    $sql = "SELECT * FROM produse WHERE id_produs = 3;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
    	$row = mysqli_fetch_assoc($result);    
    	$_SESSION['RGB_produs_3'] = $row['RGB'];
    	if($_SESSION['RGB_produs_3'])
    	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=3;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor3_off.py');
    	}
	else
	{
		$sql = "UPDATE produse SET RGB = !RGB WHERE id_produs=3;";
        	mysqli_query($conn, $sql);
        	exec('sudo python /var/www/arduino/led_motor3_on.py');
	}
    }
}

header("Location: ..");
exit();
?>
