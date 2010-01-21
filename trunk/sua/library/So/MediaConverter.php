<?php

class So_MediaConverter {
	
	private $_targetWidth;
	
	public function __construct($targetWidth = 200) {
		$this->setTargetWidth($targetWidth);
	}
	
	public function setTargetWidth($targetWidth) {
		$this->_targetWidth = $targetWidth;
	}
	
	public function makeImageThumbnail($source, $target, $filetype) {
	
		switch($filetype) {
			case "image/jpeg":
			case "image/pjpeg":
				$sourceImage = imagecreatefromjpeg($source);
				break;
			case "image/gif":
				$sourceImage = imagecreatefromgif($source);
				break;
			case "image/png":
				$sourceImage = imagecreatefrompng($source);
				break;
			default:
				throw new Exception("Image Converter: Unknow mime-type"); 
		}
		
		$this->_makeThumbnail($sourceImage, $target, $filetype);
		imagedestroy($sourceImage);		
	}
	
	public function makeVideoThumbnail($source, $target) {
		
		$movie = new ffmpeg_movie($source, false);
		$frame = $movie->getNextKeyFrame();
		
		$sourceImage = $frame->toGDImage();
		$this->_makeThumbnail($sourceImage, $target, "image/jpeg");
		imagedestroy($sourceImage);	
		
	}
	
	private function _makeThumbnail($sourceImage, $target, $filetype) {
		$sourceWidth = imagesx($sourceImage);
		$sourceHeight = imagesy($sourceImage);
		
		$targetWidth = $this->_targetWidth;
		$targetHeight = $targetWidth / $sourceWidth * $sourceHeight;
		
		$targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
		
		imagecopyresampled($targetImage, $sourceImage, 0,0,0,0, $targetWidth, $targetHeight,$sourceWidth, $sourceHeight);
		
		switch($filetype) {
			case "image/jpeg":
			case "image/pjpeg":
				imagejpeg($targetImage, $target);
				break;
			case "image/gif":
				imagegif($targetImage, $target);
				break;
			case "image/png":
				imagepng($targetImage, $target);
				break;
		}
		
		imagedestroy($targetImage);
		
	}
}