<?php
session_start();

require 'includes/conn.php';
require 'includes/header.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM gebruikers WHERE naam = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    if ($user && $password === $user['wachtwoord']) { 
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        header("Location: dashboard/");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>


<body>
    <div class="container">
        <div class="text-center">
            <div class="login-box">
                <h1 class="lora title">AUTHENTICATIE</h1>
                <?php if(isset($error)) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>
                <form method="POST">
                    <input class="form-control" type="text" name="username" placeholder="Gebruikersnaam">
                    <input class="form-control" type="password" name="password" placeholder="Wachtwoord">
                    <button type="submit" class="btn btn-primary w-100">Inloggen</button>
                </form>
            </div>
        </div>
    </div>
    <?php require 'includes/footer.php';?>
</body>
</html>