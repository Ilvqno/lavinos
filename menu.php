<?php 
   require 'includes/conn.php';
   require 'includes/header.php';
?>

<body>
    <div class="container">
        <div class="text-center">
            <h1 class="lora mb-5 mt-5 title">MENUKAART</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="menukaart-item">
                    <h3 class="lora">WAAR HEB JE ZIN IN?</h3>
                    <input class="form-control" type="text" id="Search" onkeyup="zoekMenukaart()" placeholder="Start hier met zoeken naar een gerecht.." title="Typ een naam in">
                </div>
            </div>
            <?php

try {
    $stmt = $conn->prepare("SELECT naam, beschrijving, prijs FROM menu");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-4 target">
                    <div class="menukaart-item">
                        <h1 class="lora">' . $row["naam"] . '</h1>
                        <p>' . $row["beschrijving"] . '</p>
                        <small>&euro;' . $row["prijs"] . '.00</small>
                    </div>
                </div>';
        }
    } else {
        echo '<div class="col-md-12">
                <div class="menukaart-item text-center">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h1>Er staan helaas geen gerechten op het menu!</h1>
                    <p>Probeer het later nog eens, we zijn altijd bezig met de lekkerste gerechten.</p>
                </div>
            </div>';
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

        </div>
    </div>
    <br>
    <?php require 'includes/footer.php';?>
</body>
</html>

<script>
    // Script via StackOverflow
    // https://stackoverflow.com/questions/43821938/search-div-for-text
    function zoekMenukaart() {
        var input = document.getElementById("Search");
        var filter = input.value.toLowerCase();
        var nodes = document.getElementsByClassName('target');

        for (i = 0; i < nodes.length; i++) {
        if (nodes[i].innerText.toLowerCase().includes(filter)) {
            nodes[i].style.display = "block";
            } else {
                nodes[i].style.display = "none";
            }
        }
    }
</script>