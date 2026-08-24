<?php
$sourceFile = __DIR__ . '/public/images/logo.png';
$targetFile = __DIR__ . '/public/images/logo.png';

$image = imagecreatefrompng($sourceFile);
if (!$image) {
    die("Failed to load image");
}

// Get dimensions
$width = imagesx($image);
$height = imagesy($image);

// Create a new true color image with alpha channel
$newImage = imagecreatetruecolor($width, $height);
imagesavealpha($newImage, true);

// Fill with fully transparent background
$transparentColor = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
imagefill($newImage, 0, 0, $transparentColor);

// Iterate through pixels
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $colorIndex = imagecolorat($image, $x, $y);
        $colors = imagecolorsforindex($image, $colorIndex);
        
        // If the pixel is very close to white (allow some tolerance for anti-aliasing)
        if ($colors['red'] > 240 && $colors['green'] > 240 && $colors['blue'] > 240) {
            // Set this pixel to transparent in the new image
            imagesetpixel($newImage, $x, $y, $transparentColor);
        } else {
            // Keep the original color
            $newColor = imagecolorallocatealpha($newImage, $colors['red'], $colors['green'], $colors['blue'], $colors['alpha']);
            imagesetpixel($newImage, $x, $y, $newColor);
        }
    }
}

// Save the new image
imagepng($newImage, $targetFile);
imagedestroy($image);
imagedestroy($newImage);

echo "Background removed successfully!";
