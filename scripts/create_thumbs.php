<?php

/*
Author @ Eric@Reinsmidt.com
This file creates creates square thumbnail images.
It reads in filenames from a directory that a user has uploaded .jpg files to.
Based on the dimensions of the image, appropriate portions of the image
are cropped to create a thumbnail whose focus is the center of the image.
The thumbnail image is then saved to a different directory for index.php
to use in creating an interactive photo gallery.
*/
function create_thumbs() {
	foreach (glob('./images/*.*') as $filename) {
		// Lowercase filenames to suppress uppercase ext, i.e. '.JPG'
		rename($filename, strtolower($filename)); // rename the file in lowercase
		$filename = strtolower($filename); // lowercase the $filename var
		if (!file_exists('./thumbs/'.str_replace('./images/', '', $filename))) {
			// Get width and height
			list($img_width, $img_height) = getimagesize($filename);
			// Set offset for square and change dimensions if needed
			$width_offset = 0;
			$height_offset = 0;
			if ($img_height < $img_width) {// landscape image
			
				$width_offset = ($img_width - $img_height)/2;
				$img_width = $img_height;
			}
			if ($img_height > $img_width) {// portrait image
			
				$height_offset = ($img_height - $img_width)/2;
				$img_height = $img_width;
			}
			// Resample
			$thumb = imagecreatetruecolor(100, 100);
			$image = imagecreatefromjpeg($filename);
			imagecopyresampled($thumb, $image, 0, 0, $width_offset, $height_offset, 100, 100, $img_width, $img_height);
			imagedestroy($image); // Free memory
			// Strip dir from filename
			$filename = substr($filename, 9);
			// Write to file
			imagejpeg($thumb, './thumbs/'.$filename);
			imagedestroy($thumb); // Free memory
		}
	}
}
?>