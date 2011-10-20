<?php
include_once './scripts/create_thumbs.php';
/*
Author @ Eric@Reinsmidt.com
This file is an experiment in uploading files to a webserver using PHP.
Up to three files can uploaded to the server at a time.
All file extensions are checked against a comprehensive list of image filetypes.
If a file is an image, uploading is allowed.
In addition, failure/success messages are given to the user to acknowledge if the upload succeeded.
Finally, a list of all files (with the exception of '.' and '..') are displayed to the user.
*/

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Image Uploader</title>
	<link rel='stylesheet' type='text/css' href='./css/upload.css' />
</head>
<body>
	<div id='wrapper'>
		<div id='upload'><h3>Select Files</h3>
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<input name="userfile[]" type="file" /><br />
				<input type="submit" value="Upload" />
			</form>
		</div>

		<?php

		echo '<div id=\'results\'><h3>Upload Results</h3>';

		for ($i = 0; $i < count($_FILES['userfile']['name']); $i++) { // check all files, future proofing to add more than three files in future
			$filename = pathinfo($_FILES['userfile']['name'][$i]);
			// list of image filetypes
			$img_list = array('JPG');
			$img = false;
			for ($j = 0; $j < count($img_list); $j++) {
				if (strtoupper($filename['extension']) == $img_list[$j]) { // check if file is an image
					$img = true;
				}
			}
			if ($img) { // upload if approved image extension
				$dir = './images/'.basename($_FILES['userfile']['name'][$i]);
				if(move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $dir)) { // if uploaded, display success
					echo '"'. basename($_FILES['userfile']['name'][$i]). 
					'" has been uploaded.<br /><br />';
				} else { // if not display failure
					echo 'The file did not upload properly.<br />Please contact the server admnistrator.<br /><br />';
				}
			}
			elseif (!empty($_FILES['userfile']['name'][$i])) { // check to see if filename is non-empty string. if it is, bitchslap.
				echo '"'.basename($_FILES['userfile']['name'][$i]).
				'" was not uploaded.<br />'.
				'Only image files are allowed.<br /><br />';
			}
		}

		echo '</div>';

		$dir = "./images/";

		echo '<div id=\'current_files\'><h3>Current Files</h3>';

		if ($dh = opendir($dir)) { // display all files in image directory
			while (($file = readdir($dh)) !== false) {
				if ($file !== '.' && $file !== '..')
					echo $file.'<br />';
			}
			closedir($dh);
		}

		echo '</div>';
		create_thumbs();
		?>
		<a href='./' style='text-decoration: none;'>View Gallery</a>
	</div>
</body>
</html>