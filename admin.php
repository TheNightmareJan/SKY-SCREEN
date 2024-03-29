<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Bereich</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
        }
        img {
            max-width: 100%;
            max-height: 70vh;
            margin-bottom: 20px;
        }
        .buttons {
            display: flex;
            justify-content: center;
        }
        .buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .buttons button.accept {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        .buttons button.reject {
            background-color: #f44336;
            color: white;
            border: none;
        }
        .buttons button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'database_config.php';

        // Daten aus der Datenbank abrufen
        $sql = "SELECT * FROM images WHERE status = 'Pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Ausgabe der Bilder zur Überprüfung
            while($row = $result->fetch_assoc()) {
                echo "<img src='Screening/{$row['file_name']}' alt='Bild'>";
                echo "<div class='buttons'>";
                echo "<form action='admin_actions.php' method='post'>";
                echo "<input type='hidden' name='image_id' value='{$row['image_id']}'>";
                echo "<input type='hidden' name='discord_username' value='{$row['discord_username']}'>";
                echo "<button type='submit' name='action' value='Accepted' class='accept'>Akzeptieren</button>";
                echo "<button type='submit' name='action' value='Rejected' class='reject'>Ablehnen</button>";
                echo "<input type='text' name='reason' placeholder='Grund (optional)'>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "Keine Bilder zur Überprüfung vorhanden.";
        }
        ?>
    </div>
</body>
</html>
