<?php 
   require '../includes/conn.php';
   require '../includes/admin.php';

   $email_address = "isislavino@gmail.com";
   $size = 100;

   $hash_email = md5(strtolower(trim($email_address)));
   $gravatar_url = "https://www.gravatar.com/avatar/{$hash_email}?s={$size}";
?>



<body>
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-md-1">
                <img src="<?php echo $gravatar_url;?>" style="border-radius: 100%;">
            </div>
            <div class="col-md-6 my-auto text-end">
                <h1 class="lora title">Welkom terug, Isis.</h1>
            </div>
        </div>
        <div class="row mt-5 mb-5">
            <div class="col-md-4">
                <div class="admin-kaart">
                    <h1><i class="fa-solid fa-calendar"></i> Reserveringen</h1><br>
                    <a class="btn btn-primary w-100" href="./reserveringen.php">Bekijk reserveringen</a>
                </div>
                <br>
                <div class="admin-kaart">
                    <h1><i class="fa-solid fa-paper-plane"></i> Berichten</h1><br>
                    <a class="btn btn-primary w-100" href="./berichten.php">Bekijk berichten</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>