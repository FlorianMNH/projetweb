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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Biens Immobiliers</title>
    <style>
        /* Ajouter un peu de style pour la mise en page */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, button {
            margin-top: 5px;
            padding: 5px;
        }
        .bien {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>Recherche de Biens Immobiliers</h1>
<form method="GET" action="">
    <label for="search">Rechercher :</label>
    <input type="text" name="search" id="search" placeholder="Nom de l'agent, numéro de propriété, ville ou commune">
    <button type="submit">Rechercher</button>
</form>

<div id="results">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);

        // Requête de recherche
        $query = "SELECT b.*, a.prenom, a.nom 
                  FROM BienImmobilier b
                  LEFT JOIN AgentImmobilier a ON b.identifiant_agent = a.identifiant_agent
                  WHERE b.identifiant_bien LIKE '%$search%' 
                  OR b.adresse LIKE '%$search%'
                  OR a.nom LIKE '%$search%'
                  OR a.prenom LIKE '%$search%'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='bien'>";
                echo "<h2>{$row['adresse']}</h2>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Type de bien: {$row['type_bien']}</p>";
                echo "<p>Prix: {$row['prix']} €</p>";
                echo "<p>Statut: {$row['statut']}</p>";
                echo "<p>Agent: {$row['prenom']} {$row['nom']}</p>";
                echo "<a href='details.php?id={$row['identifiant_bien']}'>Voir les détails</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun bien trouvé.</p>";
        }
    }
    ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
