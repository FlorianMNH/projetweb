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
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM bienimmobilier WHERE identifiant_bien=$id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $bien = $result->fetch_assoc();
} else {
    echo "<p>Bien immobilier non trouvé.</p>";
    exit;
}

// Récupérer les agents spécialisés dans la catégorie du bien
$specialite = $bien['type_bien'];
$agentQuery = "SELECT * FROM agentimmobilier WHERE specialite='$specialite'";
$agentResult = $conn->query($agentQuery);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Bien</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .sidebar {
            float: left;
            width: 25%;
            padding: 10px;
            background-color: #f9f9f9;
            border-right: 1px solid #ddd;
        }
        .content {
            float: left;
            width: 70%;
            padding: 10px;
        }
        .agent {
            margin-bottom: 10px;
        }
        .bien-details {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>Détails du Bien</h1>
<div class="sidebar">
    <h2>Agents Spécialisés</h2>
    <?php
    if ($agentResult->num_rows > 0) {
        while ($agent = $agentResult->fetch_assoc()) {
            echo "<div class='agent'>";
            if (!empty($agent['Photo'])) {
                echo "<img src='images/" . $agent['Photo'] . "' alt='Photo de l'agent' style='width:100%;height:auto;'>";
            } else {
                echo "<p>Aucune photo disponible</p>";
            }
            echo "<p>" . $agent['prenom'] . " " . $agent['nom'] . "</p>";
            echo "<p>Email: " . $agent['email'] . "</p>";
            echo "<p>Téléphone: " . $agent['telephone'] . "</p>";
            echo "<a href='agent.php?id_agent=" . $agent['identifiant_agent'] . "'>Voir les détails</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun agent spécialisé trouvé.</p>";
    }
    ?>
</div>

<div class="content">
    <div class="bien-details">
        <h2><?php echo $bien['adresse']; ?></h2>
        <p><?php echo $bien['description']; ?></p>
        <p>Type de bien: <?php echo $bien['type_bien']; ?></p>
        <p>Prix: <?php echo $bien['prix']; ?> €</p>
        <p>Statut: <?php echo $bien['statut']; ?></p>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
