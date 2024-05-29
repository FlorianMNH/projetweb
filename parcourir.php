<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OmnesImmobilier";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'Immobilier résidentiel';

$query = "SELECT * FROM BienImmobilier WHERE type_bien='$categorie'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Tout Parcourir</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Tout Parcourir</h1>
<div class="categories">
    <a href="parcourir.php?categorie=Immobilier résidentiel">Immobilier résidentiel</a>
    <a href="parcourir.php?categorie=Immobilier commercial">Immobilier commercial</a>
    <a href="parcourir.php?categorie=Terrain">Terrain</a>
    <a href="parcourir.php?categorie=Appartement à louer">Appartement à louer</a>
</div>

<div class="biens">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='bien'>";
            echo "<h2>" . $row['adresse'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Prix: " . $row['prix'] . " €</p>";
            echo "<p>Statut: " . $row['statut'] . "</p>";
            echo "<a href='details.php?id=" . $row['identifiant_bien'] . "'>Voir les détails</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun bien trouvé dans cette catégorie.</p>";
    }
    ?>
</div>
</body>
</html>

