<?php
function throttle_requests() {
    $CI =& get_instance(); // Get CI instance

    // Get client IP and current route
    $ip_address = $CI->input->ip_address();
    $route = $CI->uri->uri_string(); // Includes login/authenticate

    // Throttle settings
    $key = md5($ip_address . '_' . $route);
    $limit = 500; // Maximum allowed requests
    $window = 15; // Time window in seconds
    $block_duration = 300; // Block duration in seconds (5 minutes)

    // Check if the IP is already blocked
    if (isset($_SESSION['blocked_ips'][$ip_address])) {
        $blocked_until = $_SESSION['blocked_ips'][$ip_address];
        if (time() < $blocked_until) {
            // IP is still blocked
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Your IP has been temporarily blocked.']);
            exit;
        } else {
            // Remove the block if the duration has passed
            unset($_SESSION['blocked_ips'][$ip_address]);
        }
    }

    // Initialize or update throttle data
    if (!isset($_SESSION['throttle'][$key])) {
        $_SESSION['throttle'][$key] = ['count' => 1, 'expires_at' => time() + $window];
    } else {
        $data = $_SESSION['throttle'][$key];
        if (time() > $data['expires_at']) {
            // Reset throttle data if the time window has expired
            $_SESSION['throttle'][$key] = ['count' => 1, 'expires_at' => time() + $window];
        } else {
            // Increment the request count
            $_SESSION['throttle'][$key]['count']++;
        }
    }

    // Check if the request limit is exceeded
    if ($_SESSION['throttle'][$key]['count'] > $limit) {
        // Block the IP if the limit is exceeded
        $_SESSION['blocked_ips'][$ip_address] = time() + $block_duration;
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['status' => 'error', 'message' => 'You have exceeded the maximum request limit. Please wait for 5 minutes before attempting again.']);
        exit;
    }
}

