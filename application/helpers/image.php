<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('compress_image_to_base64')) {
    function compress_image_to_base64($imageData, $maxSizeKB = 500, $minQuality = 10)
    {
        // --- fetch if it's a URL ---
        if (is_string($imageData) && preg_match('#^https?://#i', $imageData)) {
            $fetched = _img_fetch($imageData);
            if ($fetched === false) {
                log_message('error', 'compress_image_to_base64: failed to fetch URL '.$imageData);
                return null;
            }
            $imageData = $fetched;
        }

        if (empty($imageData)) {
            log_message('error', 'compress_image_to_base64: empty $imageData');
            return null;
        }
        if (!function_exists('imagecreatefromstring')) {
            log_message('error', 'compress_image_to_base64: GD not available');
            return null;
        }

        $src = @imagecreatefromstring($imageData);
        if (!$src) {
            log_message('error', 'compress_image_to_base64: imagecreatefromstring failed (bad data?)');
            return null;
        }

        // Optional downscale (helps reduce size a lot)
        $maxW = 1000; $maxH = 1000;
        $w = imagesx($src); $h = imagesy($src);
        if ($w > $maxW || $h > $maxH) {
            $ratio = min($maxW / $w, $maxH / $h);
            $nw = max(1,(int)round($w*$ratio));
            $nh = max(1,(int)round($h*$ratio));
            $resized = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($resized, $src, 0,0,0,0, $nw,$nh, $w,$h);
            imagedestroy($src);
            $src = $resized;
        }

        $maxBytes = $maxSizeKB * 1024;
        $quality = 90;

        do {
            ob_start();
            imagejpeg($src, null, $quality); // force JPEG for best compression
            $compressed = ob_get_clean();

            if (strlen($compressed) <= $maxBytes || $quality <= $minQuality) break;
            $quality -= 5;
        } while (true);

        imagedestroy($src);

        if (empty($compressed)) {
            log_message('error', 'compress_image_to_base64: compression produced empty output');
            return null;
        }

        return 'data:image/jpeg;base64,' . base64_encode($compressed);
    }

    // Robust fetch (supports servers where allow_url_fopen is off)
    function _img_fetch($url)
    {
        if (ini_get('allow_url_fopen')) {
            $ctx = stream_context_create(['http'=>['timeout'=>5],'https'=>['timeout'=>5]]);
            $d = @file_get_contents($url, false, $ctx);
            if ($d !== false) return $d;
        }
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $d = curl_exec($ch);
            curl_close($ch);
            if ($d !== false) return $d;
        }
        return false;
    }
}

