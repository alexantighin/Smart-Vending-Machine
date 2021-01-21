<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Smart Vending Machine</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
</head>

<body style="background-color: #eeeff1;">
    <main class="page contact-page">
        <section class="portfolio-block contact">
            <div class="container">
                <div class="heading">
                    <h1>Poți schimba datele tale!</h1>
                </div>
   
                    <?php
                    session_start();
                    echo'
                    <form class="user" action="includes/comenzi_inregistrare_informatii.php" method="post" style="background-color: #ffffff;">
                        <div class="form-group"><label for="name">Nume</label><input class="form-control item" type="text" id="name" name="last_name" value="' . htmlspecialchars($_SESSION['nume_utilizator']) . '"></div>
                        <div class="form-group"><label for="name">Prenume</label><input class="form-control item" type="text" id="subject" name="first_name" value="' . htmlspecialchars($_SESSION['prenume_utilizator']) . '"></div>
                        <div class="form-group"><label for="subject">Produs favorit: 1 - Gel Antibacterian | 2 - Manusi | 3 - Masca</label><input class="form-control item" type="text" id="subject" name="optiune" value="' . htmlspecialchars($_SESSION['id_produs']) . '"></div>
                        <div class="form-group"><button class="btn btn-primary btn-block btn-lg" type="submit" name="salvare-submit" style="background-color: #5a5a5a;">Salvare</button></div>
                         </form>  
                        ';
                    
                    ?>            
                    
                   
                </form>
            </div>
        </section>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>