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

$id_agent = isset($_GET['id_agent']) ? intval($_GET['id_agent']) : 0;

$query = "SELECT * FROM AgentImmobilier WHERE identifiant_agent=$id_agent";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $agent = $result->fetch_assoc();
} else {
    echo "<p>Agent immobilier non trouvé.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date_heure'])) {
    $id_client = 1; // Remplacez par l'ID du client actuel connecté
    $date_heure = $_POST['date_heure'];

    $query_rdv = "INSERT INTO RendezVous (identifiant_client, identifiant_agent, date_heure, statut) VALUES ($id_client, $id_agent, '$date_heure', 'Programmé')";
    if ($conn->query($query_rdv) === TRUE) {
        echo "<p>Rendez-vous pris avec succès !</p>";
    } else {
        echo "<p>Erreur lors de la prise de rendez-vous : " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Agent Immobilier</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .calendar-table {
            width: 100%;
            border-collapse: collapse;
        }
        .calendar-table th, .calendar-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .available {
            background-color: #c8e6c9;
            cursor: pointer;
        }
        .unavailable {
            background-color: #ffcdd2;
        }
    </style>
    <script>
        function selectSlot(date_heure) {
            document.getElementById('date_heure').value = date_heure;
            document.getElementById('appointment-form').submit();
        }
    </script>
</head>
<body>
<h1>Détails de l'Agent Immobilier</h1>
<div class="agent-details">
    <img src="images/<?php echo $agent['Photo']; ?>" alt="Photo de l'agent" />
    <h2><?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
    <p>Email: <?php echo $agent['email']; ?></p>
    <p>Téléphone: <?php echo $agent['telephone']; ?></p>
    <h3>Disponibilité de l'agent</h3>
    <form id="appointment-form" method="POST" action="agent.php?id_agent=<?php echo $id_agent; ?>">
        <input type="hidden" name="date_heure" id="date_heure">
    </form>
    <table class="calendar-table">
        <tr>
            <th>Jour</th>
            <th>Matin</th>
            <th>Après-midi</th>
        </tr>
        <tr>
            <td>Lundi</td>
            <td class="<?php echo ($agent['disponibilite_lundi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-03 09:00:00')"><?php echo $agent['disponibilite_lundi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_lundi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-03 14:00:00')"><?php echo $agent['disponibilite_lundi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Mardi</td>
            <td class="<?php echo ($agent['disponibilite_mardi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-04 09:00:00')"><?php echo $agent['disponibilite_mardi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_mardi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-04 14:00:00')"><?php echo $agent['disponibilite_mardi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Mercredi</td>
            <td class="<?php echo ($agent['disponibilite_mercredi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-05 09:00:00')"><?php echo $agent['disponibilite_mercredi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_mercredi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-05 14:00:00')"><?php echo $agent['disponibilite_mercredi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Jeudi</td>
            <td class="<?php echo ($agent['disponibilite_jeudi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-06 09:00:00')"><?php echo $agent['disponibilite_jeudi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_jeudi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-06 14:00:00')"><?php echo $agent['disponibilite_jeudi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Vendredi</td>
            <td class="<?php echo ($agent['disponibilite_vendredi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-07 09:00:00')"><?php echo $agent['disponibilite_vendredi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_vendredi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-07 14:00:00')"><?php echo $agent['disponibilite_vendredi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Samedi</td>
            <td class="<?php echo ($agent['disponibilite_samedi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-08 09:00:00')"><?php echo $agent['disponibilite_samedi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_samedi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-08 14:00:00')"><?php echo $agent['disponibilite_samedi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Dimanche</td>
            <td class="<?php echo ($agent['disponibilite_dimanche_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-09 09:00:00')"><?php echo $agent['disponibilite_dimanche_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_dimanche_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-09 14:00:00')"><?php echo $agent['disponibilite_dimanche_apres_midi']; ?></td>
        </tr>
    </table>
    <a href="agent.php?id_agent=<?php echo $agent['identifiant_agent']; ?>&action=cv">Voir son CV</a>
    <a href="agent.php?id_agent=<?php echo $agent['identifiant_agent']; ?>&action=communiquer">Communiquer avec l'agent</a>
</div>
</body>
</html>

<?php
$conn->close();
?>
