<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Raspberry Pi Video Upload</title>
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			min-height: 100vh;
		}
		input {
			font-size: 2rem;
		}
		a {
			text-decoration: none;
			color: #006CFF;
			font-size: 1.5rem;
		}
	</style>
</head>
<body>
	<a href="raspberry_view.php">Raspberry Pi Videos</a>
	<?php if (isset($_GET['error'])) {  ?>
		<p><?=$_GET['error']?></p>
	<?php } ?>
	 <form action="raspberry_upload.php"
	       method="post"
	       enctype="multipart/form-data">

	 	<input type="file"
	 	       name="my_video">

	 	<input type="submit"
	 	       name="submit"
	 	       value="Upload">
	 </form>
</body>
</html>

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

if (isset($_POST['submit']) && isset($_FILES['my_video'])) {
    print_r($_FILES['my_video']);
    $video_name = $_FILES['my_video']['name'];
    $tmp_name = $_FILES['my_video']['tmp_name'];
    $error = $_FILES['my_video']['error'];
   var_dump($error);
    var_dump($video_name);
    if ($error === 0) {
        $video_ex = pathinfo($video_name, PATHINFO_EXTENSION);
	var_dump($error);
        $video_ex_lc = strtolower($video_ex);

        $allowed_exs = array("mp4", 'webm', 'avi', 'flv');

        if (in_array($video_ex_lc, $allowed_exs)) {

            $new_video_name = uniqid("video-", true) . '.' . $video_ex_lc;
            $video_upload_path = '/var/www/monsite.fr/raspberry_uploads/' . $new_video_name;
            move_uploaded_file($tmp_name, $video_upload_path);

            // Now let's Insert the video path into database
            $sql = "INSERT INTO raspberry_videos(video_url)
                   VALUES('$new_video_name')";
            mysqli_query($conn, $sql);
            header("Location: raspberry_view.php");
        } else {
            $em = "You can't upload files of this type";
            header("Location: raspberry_upload.php?error=$em");
        }
    } else {
        var_dump($error);
	header("Location: raspberry_upload.php?error=Error uploading the video.");
   	echo "Error uploading the video. Error code: " . $error;
   }
}
?>
