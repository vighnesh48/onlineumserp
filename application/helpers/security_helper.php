<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function detect_suspicious_activity() {
    $CI = &get_instance();
    $user_ip = $CI->input->ip_address();
    $user_agent = $CI->input->user_agent();
    $requested_url = current_url();
    $method = $_SERVER['REQUEST_METHOD'];
    $query_string = $_SERVER['QUERY_STRING'] ?? '';
    $session_um_id = $CI->session->userdata('uid'); // Get session ID

    // **Detect SQL Injection & XSS Attacks**
    $suspicious_patterns = [
        '/(union select|select.*from.*where|insert into|drop table|update.*set)/i', // SQL Injection
        '/(script|alert|onerror|onload|iframe)/i', // XSS Attack
        '/(\bOR\b\s+\d=\d|\bAND\b\s+\d=\d)/i', // SQL Boolean Injection
        '/(<|>|&lt;|&gt;)/i' // XSS Attempt
    ];

    foreach ($suspicious_patterns as $pattern) {
        if (preg_match($pattern, $query_string)) {
            log_suspicious_activity($user_ip, $user_agent, $requested_url, "SQL/XSS ATTACK", $session_um_id);

            // **Track but do not block if um_id=5475**
            if ($session_um_id == 5475) {
                return; // Just log, do NOT block
            }

            block_attacker();
        }
    }

    // **Detect Burp Suite/Proxy Users**
    if (strpos(strtolower($user_agent), 'burp') !== false || strpos(strtolower($user_agent), 'proxy') !== false) {
        log_suspicious_activity($user_ip, $user_agent, $requested_url, "BURP SUITE DETECTED", $session_um_id);

        // **Track but do not block if um_id=5475**
        if ($session_um_id == 5475) {
            return; // Just log, do NOT block
        }

        block_attacker();
    }
}

function log_suspicious_activity($ip, $user_agent, $url, $reason) {
    $CI = &get_instance();
    $CI->db->insert('cyber_activity_logs', [
        'ip_address' => $ip,
        'user_agent' => $user_agent,
        'url_attempted' => $url,
        'reason' => $reason,
        'timestamp' => date("Y-m-d H:i:s")
    ]);

    // **Trigger Screenshot Capture**
    file_get_contents(base_url("capture_screenshot"));
}

function block_attacker() {
    header("HTTP/1.0 403 Forbidden");
    echo "Unauthorized Access.";
    exit();
	
}
?>
