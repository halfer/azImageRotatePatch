<?php
/*
Plugin Name: imagerotate() Patch
Plugin URI: http://www.activezero.co.uk/
Description: Will patch GD imagerotate() for Ubuntu systems.
Version: 0.1b
Author: Activezero 
Author URI: http://www.activezero.co.uk/
*/



if(!function_exists("imagerotate"))
{
	function imagerotate($img, $angle, $bgd_color, $ignore_transparent = 0) {
	  
	  $width = imagesx($img);
	  $height = imagesy($img);
	  
	  if($angle < 0) $angle = 360 - $angle;
	  
	  switch($angle) {
		case 90: 
			$newimg= @imagecreatetruecolor($height , $width );
			break;
		case 180: 
			$newimg= @imagecreatetruecolor($width , $height );
			break;
		case 270: 
			$newimg= @imagecreatetruecolor($height , $width );
			break;
		default: 
			return $img;
	  }
	  
	  if($ignore_transparent == 0)
	  {
		@imagefill($newimg, 0, 0, $bgd_color);
	  }
	  
	  if($newimg) {
		for($i = 0;$i < $width ; $i++) {
		  for($j = 0;$j < $height ; $j++) {
			$reference = imagecolorat($img,$i,$j);
			switch($angle) {
			  case 90: 
				if(!@imagesetpixel($newimg, ($height - 1) - $j, $i, $reference ))
				{
					return false;
				}
				break;
			  case 180: 
				if(!@imagesetpixel($newimg, $width - $i, ($height - 1) - $j, $reference ))
				{
					return false;
				}
				break;
			  case 270:
				if(!@imagesetpixel($newimg, $j, $width - $i, $reference ))
				{
					return false;
				}
				break;
			}
		  }
		} return $newimg;
	  }
	  return false;
	}
}

?>