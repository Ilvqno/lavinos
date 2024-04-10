<?php 
   require '../includes/conn.php';
   require '../includes/admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['verwijderen'])) {
    $id = $_POST["id"];
    $sql = "DELETE FROM menu WHERE id = :menu_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':menu_id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
            echo '<div class="container"><div class="alert alert-success" role="alert">
            Item succesvol Verwijderd!
          </div></div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Helaas is dit item niet verwijderd
          </div>';
        }
    }
  }
  if (isset($_POST['toevoegen'])) {
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    
    try {
        // Prepare SQL statement
        $sql = "INSERT INTO menu (naam, beschrijving, prijs) VALUES (:naam, :beschrijving, :prijs)";
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':beschrijving', $beschrijving);
        $stmt->bindParam(':prijs', $prijs);
        
        // Execute the query
        $stmt->execute();
        
        echo '<div class="container"><div class="alert alert-success" role="alert">
        Item succesvol toegevoegd!
      </div></div>';
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">
            Helaas is dit item niet toegevoegd! Error: ' . $e->getMessage() . '
          </div>';
    }
  }

?>

<body>
    <div class="container">
        <div class="mt-5 mb-5 lora">
            <div class="row">
                <div class="col-md-9">
                  <h1 class="title">Menukaart.</h1>
                </div>
                <div class="col-md-3 mt-4 text-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      Voeg toe
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Toevoegen van product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <form method="POST">
                                            <input class="form-control"  type="text" name="naam" placeholder="Titel van product" required>
                                            <textarea class="form-control" name="beschrijving" placeholder="Beschrijving" required></textarea>
                                            <input class="form-control" type="text" name="prijs" placeholder="Prijs" required>
                                            <button type="submit" class="btn btn-primary w-100" name="toevoegen"><i style="margin-right: 7px;" class="fa-solid fa-paper-plane"></i> TOEVOEGEN</button>
                                        </form>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
            <p>Bekijk & bewerk alle menukaart items voor Lavino's</p>
        </div>
        <input class="form-control" type="text" id="Search" onkeyup="zoekMenukaart()" placeholder="Start hier met zoeken naar een gerecht.." title="Typ een naam in">
        <div class="row">
        <?php

try {
    
    $stmt = $conn->prepare("SELECT id, naam, beschrijving, prijs FROM menu");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-4 target">
                    <div class="menukaart-item">
                        <h1 class="lora">' . $row["naam"] . '<a href="./bewerk.php?id=' . $row["id"] . '"><i style="font-size: 36px; color: black; margin-left: 10px;"class="fa-solid fa-pencil"></i></a></h1>
                        <p>' . $row["beschrijving"] . '</p>
                        <h4>&euro;' . $row["prijs"] . '.00</h4><br>
                        <form method="POST">
                          <input type="hidden" name="id" value="' . $row["id"] .'">
                          <button type="submit" name="verwijderen" class="btn btn-primary w-100" style="background-color: #fb4a4a;"><i style="font-size: 22px; margin-bottom: -1px; color: white; margin-right: 8px;" class="fa-solid fa-trash-can"></i> Verwijderen</a>
                        </form>
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
</body>
</html>