<!DOCTYPE HTML>
<?php

/*
Author @ Eric@Reinsmidt.com
This file calls create_thumbs.php
This file calls modal_img.js
This file also reads n filenames from a directory, and if the file is a .jpg,
it is added to an html page that displays the images and adds javascript onclick event code.
*/

?>
<html>
<head>
	<title>Image Gallery</title>
	<link rel="stylesheet" type="text/css" href="css/gallery.css" />
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js' type='text/javascript'></script>
	<script src='scripts/modal_img.js' type='text/javascript'></script>
</head>
<body>
	<?php
		echo '<div id=\'shadow\'></div>';
		echo '<div id=\'spinner\'><img src=\'./spinner.gif\' /></div>';
		echo '<div id=\'wrapper\'>';
		$new_row = 0;
		foreach (glob('./thumbs/*.*') as $filename) {
			$filename = substr($filename, 9);
			if (pathinfo($filename, PATHINFO_EXTENSION) == 'jpg') {
				if ($new_row % 5 == 0) {
					echo '<div class=\'clear\'></div>';
				}
				$new_row++;
				echo '<a onclick=\'img_over('.$new_row.', "'.$filename.'");\'><img src=\'./thumbs/'.$filename.'\' /></a>';
			}
		}
		echo '</div>';
	?>
</body>
</html>