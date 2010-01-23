<?php
/**
 * SUA
 * 
 * LICENSE 
 * 
 * This file is part of Switched On Upload Agent (SUA).
 *
 * SUA is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SUA is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SUA.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright Copyright (c) 2009-2010 Switched On (International)
 * @author Peter Smit, (peter AT smitmail DOT eu)
 * 
 */


class So_MediaConverter 
{

    /**
     * @var int
     */
    private $_targetWidth;

    /**
     * @param int $targetWidth
     * @return void
     */
    public function __construct($targetWidth = 200) 
    {
        $this->setTargetWidth($targetWidth);
    }

    /**
     * @param int $targetWidth
     * @return void
     */
    public function setTargetWidth($targetWidth) 
    {
        $this->_targetWidth = $targetWidth;
    }

    /**
     * @param string $source
     * @param string $target
     * @param string $filetype
     * @return void
     */
    public function makeImageThumbnail($source, $target, $filetype) 
    {
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

    /**
     * @param string $source
     * @param string $target
     * @return void
     */
    public function makeVideoThumbnail($source, $target) 
    {
        $movie = new ffmpeg_movie($source, false);
        $frame = $movie->getNextKeyFrame();

        $sourceImage = $frame->toGDImage();
        $this->_makeThumbnail($sourceImage, $target, "image/jpeg");
        imagedestroy($sourceImage);
    }

    /**
     * @param resource $sourceImage
     * @param string $target
     * @param string $filetype
     * @return void
     */
    private function _makeThumbnail($sourceImage, $target, $filetype) 
    {
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