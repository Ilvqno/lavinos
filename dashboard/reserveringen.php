<?php 
   require '../includes/conn.php';
   require '../includes/admin.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['goedkeuren'])) {
            $id = $_POST['id'];
            
            $sql = "UPDATE reserveringen SET status = 2 WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            echo '<div class="alert alert-success" role="alert">
            Reservering succesvol goedgekeurd!
          </div>';
            exit;
        } elseif (isset($_POST['afkeuren'])) { 
            $id = $_POST['id'];
            $sql = "UPDATE reserveringen SET status = 1 WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            echo '<div class="alert alert-success" role="alert">
                        Reservering succesvol geweigerd!
                  </div>';
            exit;
        }
    }
?>


<body>
    <div class="container">
        <div class="mt-5 mb-5 lora">
            <h1 class="title">Reserveringen.</h1>
            <p>Bekijk alle reserveringen voor Lavino's</p>
        </div>
        <?php 

try {
    $sql = "SELECT id, naam, datum, tijd, status FROM reserveringen";
    $stmt = $conn->query($sql);

    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $statuscode = $row['status'];
            if ($statuscode == "1"){
                $definitievestatus = "Geweigerd";
            } else if ($statuscode == "2") {
                $definitievestatus = "Geaccepteerd";
            } else {
                $definitievestatus = "Niet bekend";
            }

            if ($definitievestatus == "Geweigerd") {
                $button = '<button class="btn btn-success" type="submit" name="goedkeuren"><i class="fa-solid fa-check"></i></button>
                ';
            } else if ($definitievestatus == "Geaccepteerd") {
                $button = '<button class="btn btn-danger" type="submit" name="afkeuren"><i class="fa-solid fa-xmark"></i></button>';
            } else {
                $button = '<button class="btn btn-success" type="submit" name="goedkeuren"><i class="fa-solid fa-check"></i></button><button class="btn btn-danger" type="submit" name="afkeuren"><i class="fa-solid fa-xmark"></i></button>';
            }

            echo ' <div class="reservering">
            <div class="row">
                <div class="col-md-3">
                    <p>Naam</p>
                    <h3>' . $row['naam'] . '</h3>
                </div>
                <div class="col-md-2">
                    <p>Datum</p>
                    <h3>' . $row['datum'] . '<h3>
                </div>
                <div class="col-md-2">
                    <p>Tijdstip</p>
                    <h3>' . $row['tijd'] . '<h3>
                </div>
                <div class="col-md-2">
                    <p>Status</p>
                    <h3>' . $definitievestatus . '<h3>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-2 text-end my-auto">
                    <form method="POST">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        ' . $button . '
                    </form>
                </div>
            </div>
        </div>';
        }
    } else {
        echo '<div class="col-md-12">
                <div class="menukaart-item text-center">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h1>Er staan helaas geen reserveringen in de agenda!</h1>
                    <p>Probeer het later nog eens, wanneer klanten besloten hebben iets te plaatsen.</p>
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

</body>
</html>