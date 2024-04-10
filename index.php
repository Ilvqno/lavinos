<?php 
   require 'includes/conn.php';
   require 'includes/header.php';
?>

<body>
    <div class="container">
        <div class="div" style="margin-top: 100px; margin-bottom: 30px;">
            .
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="headline">
              <h1 class="big-text">Ontdek</h1>
              <h1 class="big-text lora">LAVINOS</h1>
              <p>Op zoek naar de perfecte lunchplek of een snelle koffiepauze? LAVINOS is jouw ultieme bestemming in Nijmegen. Met een gevarieerd menu en een gezellige sfeer bieden wij een onvergetelijke culinaire ervaring die je zal verrassen. Kom langs en geniet bij LAVINOS!</p>
              <a class="btn btn-primary">Lees meer</a>
            </div>
          </div>
          <div class="col-md-6 my-auto">
            <img src="assets/img/cake.png" width="100%">
          </div>
        </div>
    </div>
    <div class="container-fluid coffee text-center">
        <h1>Onze locatie</h1>
        <p>Ontdek de perfecte combinatie van heerlijke koffie en verrukkelijke lunchgerechten 
                                    op de meest uitnodigende locatie in Nijmegen.</p>
        <a class="btn btn-primary">Lees meer</a>

    </div>
    <div class="container about">
        <div class="text-center lora">
            <h1>OVER ONS</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="assets/img/cake.png" width="100%">
            </div>
            <div class="col-md-6 my-auto text-end">
                <p>Welkom bij LAVINOS - dé plek voor oprechte, gepassioneerde ervaringen. Ons doel is om jouw favoriete koffie perfect te maken, met zorg bereid door onze barista's. Als je geen koffieliefhebber bent, geen zorgen! We hebben ook een assortiment verse thee. Onze lunchgerechten hebben een verrassende twist, en we hebben altijd zelfgemaakte zoetigheden beschikbaar. Kom langs bij LAVINOS en geniet van een unieke smaakervaring!</p>
            </div>
        </div>
    </div>
    <div class="container reserveren" id="reserveren">
        <div class="row">
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $status = "0";
    
    try {
        $stmt = $conn->prepare("INSERT INTO reserveringen (naam, datum, tijd, status) VALUES (:naam, :datum, :tijd, :status)");
        
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':datum', $datum);
        $stmt->bindParam(':tijd', $tijd);
        $stmt->bindParam(':status', $status);
        
        $stmt->execute();
        
        echo '<div class="alert alert-success" role="alert">
            Reservering succesvol gemaakt!
          </div>';
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">
            We konden helaas geen plek voor je vinden. Error: ' . $e->getMessage() . '
          </div>';
    }
    
    $conn = null;
}
?>

            <div class="col-md-6">
                <h1 class="lora">RESERVEREN</h1>

                <form method="POST">
                    <input class="form-control w-80" type="text" name="naam" placeholder="Naam" required>
                    <input class="form-control w-80" type="date" name="datum" placeholder="Datum" required>
                    <input class="form-control w-80" type="time" name="tijd" placeholder="Tijd" required>
                    <button class="btn btn-primary w-80" type="submit"><b>RESERVEREN</b></button>
                </form>
            </div>
            <div class="col-md-6">
                <img src="assets/img/cake.png" width="100%">
            </div>
        </div>
    </div>
    <?php require 'includes/footer.php';?>
</body>
</html>