<?php 
   require '../includes/conn.php';
   require '../includes/admin.php';
   
   if(isset($_GET['id'])) {
       $id = $_GET['id'];
       $sql = "SELECT * FROM menu WHERE id = :menu_id";
       $stmt = $conn->prepare($sql);
       $stmt->bindParam(':menu_id', $id);
       $stmt->execute();
       $menu_item = $stmt->fetch(PDO::FETCH_ASSOC);
   }

   if ($id == "") {
     header("./menu.php");
   }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['naam'];
    $description = $_POST['omschrijving'];
    $price = $_POST['prijs'];

    $sql = "UPDATE menu SET naam = :name, beschrijving = :description, prijs = :price WHERE id = :menu_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':menu_id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);

    if ($stmt->execute()) {
        echo '<br><br><div class="container"><div class="alert alert-success" role="alert">
        Item succesvol bewerkt!
      </div><br><a href="./menu.php" class="btn btn-primary w-100">Klik hier om terug te gaan naar de menukaart.</a></div>
    ';
        exit;
    } else {
        echo "Er is iets fout.";
        exit;
    }
}
   ?>

<body>
    <div class="container">
        <div class="mt-5 mb-5 lora">
            <small>Bewerkingsmodus</small>
            <h1>Je bewerkt nu "<?php echo $menu_item['naam']; ?>"</h1>
        </div>
        <div class="row">
    <div class="col-md-8">
        <div class="contact-formulier" style="height: 570px;">
            <form id="menuForm" method="POST">
                <p>Naam</p>
                <input class="form-control"  type="text" name="naam" placeholder="Welke naam past bij dit product?" value="<?php echo $menu_item['naam']; ?>">
                <p>Prijs</p>
                <input class="form-control" type="text" name="prijs" placeholder="Wat is de prijs?" value="<?php echo $menu_item['prijs']; ?>">
                <p>Omschrijving</p>
                <textarea class="form-control" name="omschrijving" placeholder="Geef een pakkende beschrijving van het product"><?php echo $menu_item['beschrijving']; ?></textarea>
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-pencil"></i> BIJWERKEN</button>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <h3>Zo zien klanten mij.</h3><br>
        <div class="menukaart-item">
            <h1 class="lora"></h1>
            <p></p>
            <h4>&euro;</h4><br>
        </div>
    </div>
</div>

<script>
    // Mix van StackOverflow / JS documentatie
    const form = document.getElementById('menuForm');
    const naamInput = form.querySelector('input[name="naam"]');
    const prijsInput = form.querySelector('input[name="prijs"]');
    const omschrijvingTextarea = form.querySelector('textarea[name="omschrijving"]');

    function updateMenuItem() {
        const naam = naamInput.value;
        const prijs = prijsInput.value;
        const omschrijving = omschrijvingTextarea.value;

        const menuItem = document.querySelector('.menukaart-item');
        menuItem.querySelector('h1').textContent = naam;
        menuItem.querySelector('p').textContent = omschrijving;
        menuItem.querySelector('h4').innerHTML = '&euro;' + prijs;
    }

    form.addEventListener('input', updateMenuItem);
</script>

</body>
</html>