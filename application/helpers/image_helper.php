<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Compress an image (binary or URL) to <= $maxSizeKB and return a Base64 data URI.
 * Requires GD.
 */
if (!function_exists('compress_image_to_base64')) {
    function compress_image_to_base64($imageData, $maxSizeKB = 500, $minQuality = 10)
    {
        // If it's a URL, fetch it
        if (is_string($imageData) && preg_match('#^https?://#i', $imageData)) {
            $fetched = @file_get_contents($imageData);
            if ($fetched !== false) $imageData = $fetched;
        }

        if (empty($imageData)) return null;
        if (!function_exists('imagecreatefromstring')) return null; // GD missing

        $src = @imagecreatefromstring($imageData);
        if (!$src) return null;

        // Optional: downscale large images first (helps size a lot)
        $maxW = 1000; // adjust if you want
        $maxH = 1000;
        $w = imagesx($src);
        $h = imagesy($src);
        if ($w > $maxW || $h > $maxH) {
            $ratio = min($maxW / $w, $maxH / $h);
            $nw = max(1, (int)round($w * $ratio));
            $nh = max(1, (int)round($h * $ratio));
            $resized = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($resized, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
            imagedestroy($src);
            $src = $resized;
        }

        $maxBytes = $maxSizeKB * 1024;
        $quality  = 90;

        do {
            ob_start();
            // Encode as JPEG for best compression (even if original was PNG)
            imagejpeg($src, null, $quality);
            $compressed = ob_get_clean();

            if (strlen($compressed) <= $maxBytes || $quality <= $minQuality) break;
            $quality -= 5;
        } while (true);

        imagedestroy($src);

        return 'data:image/jpeg;base64,' . base64_encode($compressed);
    }
}
