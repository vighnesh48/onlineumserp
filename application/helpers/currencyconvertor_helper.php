<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function formatPlainCurrency($amount, $decimals = 2, $locale = 'en_IN') {
    $fmt = new NumberFormatter($locale, NumberFormatter::DECIMAL);
    $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);

    $formatted = $fmt->format($amount);

    // Fallback if NumberFormatter fails
    if (!$formatted) {
        $formatted = number_format($amount, $decimals);
    }

    return $formatted;
}
