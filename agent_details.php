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

$query = "SELECT * FROM agentimmobilier WHERE identifiant_agent=$id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $agent = $result->fetch_assoc();
    $dispoQuery = "SELECT * FROM DisponibiliteAgent WHERE identifiant_agent=$id";
    $dispoResult = $conn->query($dispoQuery);
} else {
    echo "<p>Agent immobilier non trouvé.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Agent</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Détails de l'Agent</h1>
<div class="agent-details">
    <h2><?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
    <img src="images/<?php echo $agent['Photo']; ?>" alt="Photo de <?php echo $agent['prenom'] . ' ' . $agent['nom']; ?>">
    <p>Email: <?php echo $agent['email']; ?></p>
    <p>Téléphone: <?php echo $agent['telephone']; ?></p>

    <h3>Disponibilités</h3>
    <table>
        <tr>
            <th>Jour</th>
            <th>Matin</th>
            <th>Après-midi</th>
        </tr>
        <?php while ($dispo = $dispoResult->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $dispo['jour_semaine']; ?></td>
                <td><?php echo $dispo['matin']; ?></td>
                <td><?php echo $dispo['apres_midi']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <p><a href="prendre_rdv.php?agent_id=<?php echo $agent['identifiant_agent']; ?>">Prendre un RDV</a></p>
</div>
</body>
</html>
