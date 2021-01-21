<?php
session_destroy();
session_start();
$ipAddress=$_SERVER['REMOTE_ADDR'];
$macAddr=false;

#aflare adresa MAC
$arp=`arp -n $ipAddress`;
$lines=explode("\n", $arp);

#look for the output line describing our IP address
foreach($lines as $line)
{
    $cols=preg_split('/\s+/', trim($line));
    if ($cols[0]==$ipAddress)
    {
        $macAddr=$cols[2];
    }
}

// verificare daca a fost apasat butonul de SIGN UP
if (isset($_POST['signup-submit']))
{
    require 'baza_de_date.php';    //conecatre la baza de date

    // luam datele din introduse in campurile din signup.php
    $numeUtilizator = $_POST['last_name'];
    $prenumeUtilizator = $_POST['first_name'];
    $optiuneUtilizator = $_POST['optiune'];



    //verificam daca sunt erori

    //verificare daca au fost intoduse date in toate campurile
    if (empty($numeUtilizator) || empty($prenumeUtilizator) || empty($optiuneUtilizator)) 
    {
        header("Location: ../inregistrare.php?eroare=campuri_libere");
        exit();
    }
    // verificare username, doar litere si cifre
    else if (!preg_match("/^[a-zA-Z]*$/", $numeUtilizator)) 
    {
        header("Location: ../inregistrare.php?eroare=nume_invalid");
        exit();
    }
    else if (!preg_match("/^[a-zA-Z]*$/", $prenumeUtilizator)) 
    {
        header("Location: ../inregistrare.php?eroare=prenume_invalid");
        exit();
    }
    else if (!preg_match("/^[0-9]*$/", $optiuneUtilizator)) 
    {
        header("Location: ../inregistrare.php?eroare=optiune_invalida");
        exit();
    }

    else 
    {


        // inserare date in baza de date
        $sql = "INSERT INTO utilizatori (mac_utilizator) VALUES (?);";
        // initializare o noua comanda sql folosit conexiunea din dbh.inc.php
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) 
        {
            header("Location: ../inregistrare.php?eroare=eroare_sql");
            exit();
        }
        else 
        {        
            // adaugare in comanda sql parametrii necesari
            mysqli_stmt_bind_param($stmt, "s", $macAddr);
            //executie comanda sql
            mysqli_stmt_execute($stmt);

            require 'baza_de_date.php';            
            $w=(int)$_SESSION['utilizator_id'];            
            $sql = "select * from utilizatori where mac_utilizator='$macAddr';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_assoc($result);    
                $w=(int)$row['id_utilizator'];      
            }

            $sql = "INSERT INTO detalii_utilizatori (nume_utilizator,prenume_utilizator,id_utilizator,id_produs,ultima_conectare) VALUES ('$numeUtilizator', '$prenumeUtilizator', $w, $optiuneUtilizator, now());";
            mysqli_query($conn, $sql);

            header("Location: ..");            
            exit();
        }
    }


    // inchidere conexiune
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}




if (isset($_POST['salvare-submit']))
{
    require 'baza_de_date.php';    //conecatre la baza de date

    // luam datele din introduse in campurile din signup.php
    $numeUtilizator = $_POST['last_name'];
    $prenumeUtilizator = $_POST['first_name'];
    $optiuneUtilizator = $_POST['optiune'];



    //verificam daca sunt erori

    //verificare daca au fost intoduse date in toate campurile
    if (empty($numeUtilizator) || empty($prenumeUtilizator) || empty($optiuneUtilizator)) 
    {
        header("Location: ../informatii.php?eroare=campuri_libere");
        exit();
    }
    // verificare username, doar litere si cifre
    else if (!preg_match("/^[a-zA-Z]*$/", $numeUtilizator)) 
    {
        header("Location: ../informatii.php?eroare=nume_invalid");
        exit();
    }
    else if (!preg_match("/^[a-zA-Z]*$/", $prenumeUtilizator)) 
    {
        header("Location: ../informatii.php?eroare=prenume_invalid");
        exit();
    }
    else if (!preg_match("/^[0-9]*$/", $optiuneUtilizator)) 
    {
        header("Location: ../informatii.php?eroare=optiune_invalida");
        exit();
    }
    else 
    {


     

            require 'baza_de_date.php';            
            $w=(int)$_SESSION['id_utilizator'];            


    
            $sql = "UPDATE detalii_utilizatori SET nume_utilizator = '$numeUtilizator', prenume_utilizator = '$prenumeUtilizator', id_produs = $optiuneUtilizator WHERE id_utilizator=$w;";
            mysqli_query($conn, $sql);

            header("Location: ..");            
            exit();
        }
    

    // inchidere conexiune
     mysqli_close($conn);
}

