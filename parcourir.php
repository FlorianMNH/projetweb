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

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'Immobilier résidentiel';

$query = "SELECT * FROM BienImmobilier WHERE type_bien='$categorie'";
$result = $conn->query($query);

// Récupérer les agents spécialisés dans la catégorie sélectionnée
$agentQuery = "SELECT * FROM AgentImmobilier WHERE specialite='$categorie'";
$agentResult = $conn->query($agentQuery);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Tout Parcourir</title>
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
            text-align: center;
        }
        .agent img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .agent p {
            margin: 5px 0;
        }
        .agent a {
            display: inline-block;
            margin-top: 5px;
            padding: 5px 10px;
            background-color: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .agent a:hover {
            background-color: darkblue;
        }
        .bien {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>Tout Parcourir</h1>
<div class="sidebar">
    <h2>Agents Spécialisés</h2>
    <?php
    if ($agentResult->num_rows > 0) {
        while ($agent = $agentResult->fetch_assoc()) {
            echo "<div class='agent'>";
            if (!empty($agent['Photo'])) {
                echo "<img src='images/" . $agent['Photo'] . "' alt='Photo de l'agent'>";
            } else {
                echo "<p>Aucune photo disponible</p>";
            }
            echo "<p>" . $agent['prenom'] . " " . $agent['nom'] . "</p>";
            echo "<a href='agent.php?id_agent=" . $agent['identifiant_agent'] . "'>Voir l'agent</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun agent spécialisé trouvé.</p>";
    }
    ?>
</div>

<div class="content">
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
                if (!empty($row['photo'])) {
                    echo "<img src='images/" . $row['photo'] . "' alt='Photo de la propriété' style='width:100%;height:auto;'>";
                } else {
                    echo "<p>Aucune photo disponible</p>";
                }
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
</div>
</body>
</html>

<?php
$conn->close();
?>
