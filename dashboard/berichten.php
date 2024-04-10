<?php 
   require '../includes/conn.php';
   require '../includes/admin.php';
?>
<body>
    <div class="container">
        <div class="mt-5 mb-5 lora">
            <h1 class="title">Berichten.</h1>
            <p>Bekijk alle berichten richting Lavino's</p>
        </div>

        <div class="row">
        <?php 

try {
    $sql = "SELECT naam, email, bericht, status FROM berichten";
    $stmt = $conn->query($sql);

    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $email_address = $row['email'];
            $size = 68;

            $hash_email = md5(strtolower(trim($email_address)));
            $gravatar_url = "https://www.gravatar.com/avatar/{$hash_email}?s={$size}";
            echo ' <div class="reservering col-md-4">
                    <img src="' . $gravatar_url . '" style="border-radius: 100%; margin-bottom: 25px;">
                    <h3 style="font-weight: 600;">' . $row['naam'] . '</h3>
                    <p><a href="mailto:' . $email_address . '">' . $email_address . '</a><p>
                    <hr>
                    <p>"' . $row['bericht'] . '"</p>
            </div>';
        }
    } else {
        echo '<div class="col-md-12">
                <div class="menukaart-item text-center">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h1>Er zijn helaas geen berichten gevonden!</h1>
                </div>
            </div>';
    }
} catch(PDOException $e) {
    echo '<div class="col-md-12">
            <div class="menukaart-item text-center">
                <i class="fa-solid fa-circle-exclamation"></i>
                <h1>Error: ' . $e->getMessage() . '</h1>
            </div>
        </div>';
}

?>

        </div>
    </div>
 </body>
</html>