<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('get_year_name')) {
    function get_year_name($num) {
        $map = [
            1 => 'First',
            2 => 'Second',
            3 => 'Third',
            4 => 'Fourth',
            5 => 'Fifth',
            6 => 'Sixth',
        ];
        return ($num > 6) ? 'Final+' : ($map[$num] ?? $num . 'th');
    }
}

if (!function_exists('get_academic_year_range')) {
    function get_academic_year_range($startYear) {
        // Ensure it's a numeric value to prevent accidental string issues
        if (!is_numeric($startYear)) return 'Invalid Year';

        $endYear = $startYear + 1;
        return $startYear . '-' . substr($endYear, -2); // e.g., 2025-26
    }
}