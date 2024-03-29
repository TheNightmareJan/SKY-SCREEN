<?php
include 'database_config.php';

// Bild akzeptieren oder ablehnen
if(isset($_POST['action']) && isset($_POST['image_id'])){
    $action = $_POST['action'];
    $image_id = $_POST['image_id'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : "";

    // Benachrichtigung über Discord senden, wenn Discord-Benutzername vorhanden
    $discord_username = $_POST['discord_username'];
    if(!empty($discord_username)){
        $message = "$discord_username, dein Foto wurde bearbeitet!";
        $discord_webhook_url = 'https://discord.com/api/webhooks/1222241214322049116/NdwktlskIYER5rpxp1EKEX5uveEkClH9kqlpNngrj3n4E5wQsYXYAsh7FOzLNVzS4bHD';
        $data = array('content' => $message);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($discord_webhook_url, false, $context);
    }

    // Aktualisieren des Bildstatus in der Datenbank
    $sql = "UPDATE images SET status = '$action', reason = '$reason' WHERE image_id = '$image_id'";
    if($conn->query($sql) === TRUE){
        // Erfolgsmeldung anzeigen
        echo <<<HTML
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Aktionen</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* CSS-Stile hier einfügen */
    </style>
</head>
<body>
    <div class="message-container">
        <div class="success-message">Die Aktion wurde erfolgreich durchgeführt!</div>
        <div class="redirect-message">Du wirst in Kürze zurück zur Admin-Seite weitergeleitet.</div>
    </div>

    <script>
        // Weiterleitung zur Admin-Seite nach 3 Sekunden
        setTimeout(function(){
            window.location.href = "admin.php";
        }, 3000); // 3000 Millisekunden (3 Sekunden) Verzögerung für die Weiterleitung
    </script>
</body>
</html>
HTML;
    } else {
        // Fehlermeldung anzeigen
        echo "Fehler beim Aktualisieren des Bildstatus: " . $conn->error;
    }
}
?>
