<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	body {
		display : flex;
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
	<a href="view.php">Videos</a>
	<?php if (isset($_GET['error'])){ ?>
		<p><?=$_GET['error']?></p>
	<?php } ?>
	<form action="save_upload.php" method="post" enctype="multipart/form-data">
	    <input type="hidden" name="MAX_FILE_SIZE" value="67108864" />
	    <input type="file" name="ma_video">
	    <input type="submit" name="submit" value="Upload">
	</form>
</body>
</html>
