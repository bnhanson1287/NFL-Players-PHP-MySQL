<?php  
function createImageCopy($file, $folder, $newWidth)
{
	list($width, $height) = getimagesize($file);
	$imageRatio = $width/$height;
	$newHeight = $newWidth/$imageRatio;

	$thumb = imagecreatetruecolor($newWidth, $newHeight);
	$source = imagecreatefromjpeg($file);

	//resize

	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

	$newFileName = $folder. "/" .basename($file);

	imagejpeg($thumb, $newFileName,80);

	imagedestroy($thumb);
	imagedestroy($source);
}

function createSquareImageCopy($file, $folder, $newWidth)
{
	
	//echo "$filename, $folder, $newWidth";
	//exit();

	$thumb_width = $newWidth;
	$thumb_height = $newWidth;// tweak this for ratio

	list($width, $height) = getimagesize($file);

	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;

	if($original_aspect >= $thumb_aspect) {
	   // If image is wider than thumbnail (in aspect ratio sense)
	   $new_height = $thumb_height;
	   $new_width = $width / ($height / $thumb_height);
	} else {
	   // If the thumbnail is wider than the image
	   $new_width = $thumb_width;
	   $new_height = $height / ($width / $thumb_width);
	}

	$source = imagecreatefromjpeg($file);
	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);

	// Resize and crop
	imagecopyresampled($thumb,
					   $source,0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
					   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
					   0, 0,
					   $new_width, $new_height,
					   $width, $height);
	
	$newFileName = $folder. "/" .basename($file);
	imagejpeg($thumb, $newFileName, 80);

	//echo "<p><img src=\"$newFileName\" /></p>";
}

function correctImageOrientation($filename) {
  if (function_exists('exif_read_data')) {
    $exif = exif_read_data($filename);
    if($exif && isset($exif['Orientation'])) {
      $orientation = $exif['Orientation'];
      if($orientation != 1){
        $img = imagecreatefromjpeg($filename);
        $deg = 0;
        switch ($orientation) {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }
        if ($deg) {
          $img = imagerotate($img, $deg, 0);        
        }
        // then rewrite the rotated image back to the disk as $filename 
        imagejpeg($img, $filename, 95);
      } // if there is some rotation necessary
    } // if have the exif orientation info
  } // if function exists      
}

?>
