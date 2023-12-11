<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raspberry Pi Video View</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
        video {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Raspberry Pi Videos</h1>
    <?php
    $db_name = "affichage";
    $db = "affichage";
    $dbhost = "172.17.5.202";
    $dbport = 3306;
    $dbuser = "root";
    $dbpasswd = "Koxo@361428";
    $conn = mysqli_connect($dbhost, $dbuser, $dbpasswd, $db);

    if (!$conn) {
        echo "Connection failed!";
        exit();
    }

    $result = mysqli_query($conn, "SELECT * FROM raspberry_videos");

    while ($row = mysqli_fetch_assoc($result)) {
        $video_url = $row['video_url'];
        echo "<video controls><source src='./raspberry_uploads/$video_url' type='video/mp4'></video>";
    }
    ?>
</body>
</html>
