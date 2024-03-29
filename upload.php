
<?php
include 'database_config.php';

// Verzeichnis für die zu überprüfenden Bilder
$upload_directory = "Screening";

// Überprüfen, ob ein Bild hochgeladen wurde
if(isset($_FILES['image'])){
    $image = $_FILES['image'];
    $discord_username = $_POST['discord_username'] ?? "";
    $notify_discord = isset($_POST['notify_discord']) ? 1 : 0;

    // Bild-ID generieren
    $image_id = substr(md5(uniqid()), 0, 6);
    $file_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $new_file_name = $image_id . "." . $file_extension;

    // Pfad zum Speichern des Bildes
    $target_path = $upload_directory . "/" . $new_file_name;

    // Bild hochladen
    if(move_uploaded_file($image['tmp_name'], $target_path)){
        // Daten in die Datenbank einfügen
        $sql = "INSERT INTO images (image_id, file_name, discord_username, notify_discord) VALUES ('$image_id', '$new_file_name', '$discord_username', $notify_discord)";
        if($conn->query($sql) === TRUE){
            // Erfolgsmeldung mit der Bild-ID zurückgeben
            $success_message = "YOUR IMAGE HAS BEEN UPLOADED SUCCESSFULLY!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } else {
        $error_message = "Error uploading the image.";
    }
}
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Red+Hat+Display:400,500,600,700,800,900&amp;display=swap">
    <link rel="stylesheet" href="assets/css/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/Pricing-Yearly--Monthly-badges.css">
    <link rel="stylesheet" href="assets/css/Pricing-Yearly--Monthly-icons.css">
    <link rel="stylesheet" href="assets/css/vanilla-zoom.min.css">
</head>

<body style="font-family: 'Red Hat Display', sans-serif;">
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar navbar-light">
        <div class="container"><a class="navbar-brand logo" href="#"><img width="100px" src="assets/img/SKYSCAN%20(1).png"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="upload.html">SCREENING</a></li>
                    <li class="nav-item"><a class="nav-link" href="check.html">CHECK RESULTS</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="color: rgba(9, 162, 255, 0.85);background: linear-gradient(black, var(--bs-emphasis-color)), url(&quot;assets/img/20240118150335_IMG_7882%20(2)%20-%20Maxim%20Weber.webp&quot;) center / cover no-repeat;">
            <div class="text">
                <h1 style="font-family: 'Red Hat Display', sans-serif;font-weight: bold;"><?php echo $success_message ?? $error_message ?? ''; ?></h1>
                <?php if(isset($image_id)) : ?>
                    <p><strong>THIS IS YOUR UPLOAD ID:</strong> <?php echo $image_id; ?><br><span style="text-decoration: underline;">(Remember/save this one, with this one you will see your screening results!)</span></p>
                <?php endif; ?>
                <a class="btn btn-outline-warning btn-lg" role="button" href="index.html">GO BACK</a>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2024 SKYSCREEN - CAT III GROUP</p>
        </div>
    </footer>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/baguetteBox.min.js"></script>
    <script src="assets/js/vanilla-zoom.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
