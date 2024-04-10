<?php 
   require 'includes/conn.php';
   require 'includes/header.php';
?>

<body>
    <div class="text-center lora mt-5 mb-5">
        <h1 class="contact" >Contact</h1>
    </div>
    <div class="container mb-5 mt-5">
        <div class="row">

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $bericht = $_POST['bericht'];
    $status = "0";
    
    try {        
        $stmt = $conn->prepare("INSERT INTO berichten (naam, email, bericht, status) VALUES (:naam, :email, :bericht, :status)");
        
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':bericht', $bericht);
        $stmt->bindParam(':status', $status);
        
        $stmt->execute();
        
        echo '<div class="alert alert-success" role="alert">
            Bericht succesvol verzonden!
          </div>';
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">
            We hebben uw bericht niet kunnen verzenden! Error: ' . $e->getMessage() . '
          </div>';
    }
    
    $conn = null;
}
?>

        
            <div class="col-md-6">
                <div class="contact-formulier">
                    <h1 class="lora">MEER WETEN?</h1>
                    <form method="POST">
                        <input class="form-control"  type="text" name="naam" placeholder="Wat is je naam?">
                        <input class="form-control" type="email" name="email" placeholder="Wat is je email?">
                        <textarea class="form-control" name="bericht" placeholder="Wat wil je graag vragen of zeggen?"></textarea>
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane"></i> VERZENDEN</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mapbox">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d78879.56433436068!2d5.750730467112224!3d51.842944374750864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c70878fd1ba53b%3A0xe71e6ef382b413f3!2sNijmegen!5e0!3m2!1sen!2snl!4v1709835053869!5m2!1sen!2snl" width="100%" height="450" style="border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php require 'includes/footer.php';?>
</body>
</html>