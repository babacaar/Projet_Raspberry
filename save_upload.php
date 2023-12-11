<?php
require_once "controller_config_files.php";

$conn = mysqli_connect($dbhost, $dbuser, $dbpasswd, $db);
if (!$conn) {
	echo "Connexion échoué!";
	exit();
}

if (isset($_POST['submit']) && isset($_FILES['ma_video'])){
	echo "<pre>";
	print_r($_FILES['ma_video']);
	$file_size = $_FILES['ma_video']['size'];
	echo "Taille du fichier : " . $file_size . " octets";

	$video_name = $_FILES['ma_video'] ['name'];
	$tmp_name = $_FILES['ma_video'] ['tmp_name'];
	echo "Temporaire : ". $tmp_name;
	$error = $_FILES['ma_video'] ['error'];

	if ($error === 0){
		$video_ex = pathinfo($video_name, PATHINFO_EXTENSION);

		$video_ex_lc = strtolower($video_ex);

		$allowed_exs = array("mp4", 'webm', 'avi', 'flv');

		if (in_array($video_ex_lc, $allowed_exs)) {
			$new_video_name = uniqid("video-", true). '.'.$video_ex_lc;
			$video_upload_path = "http://172.17.5.202/Videos/".$new_video_name;
			move_uploaded_file($tmp_name, $video_upload_path);

			$sql= "INSERT INTO videos(video_url)
			      VALUES('$new_video_name')";
			mysqli_query($conn, $sql);
			header("Location: view.php");

		}else{
			$em = "Vous ne pouvez chargé ce type de fichiers";
			echo $em;
		}
	}


}else{
header("Location: test2.php");
}

?>
