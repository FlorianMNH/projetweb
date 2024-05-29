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
}$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM bienImmobilier WHERE identifiant_bien=$id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $bien = $result->fetch_assoc();
    $agentQuery = "SELECT * FROM agentImmobilier WHERE identifiant_agent=" . $bien['identifiant_agent'];
    $agentResult = $conn->query($agentQuery);
    $agent = $agentResult->fetch_assoc();
} else {
    echo "<p>Bien immobilier non trouvé.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Bien</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Détails du Bien</h1>
<div class="bien-details">
    <h2><?php echo $bien['adresse']; ?></h2>
    <p><?php echo $bien['description']; ?></p>
    <p>Type de bien: <?php echo $bien['type_bien']; ?></p>
    <p>Prix: <?php echo $bien['prix']; ?> €</p>
    <p>Statut: <?php echo $bien['statut']; ?></p>
    <h3>Agent Responsable</h3>
    <p><?php echo $agent['prenom'] . " " . $agent['nom']; ?></p>
    <p>Email: <?php echo $agent['email']; ?></p>
    <p>Téléphone: <?php echo $agent['telephone']; ?></p>
</div>
</body>
</html>
