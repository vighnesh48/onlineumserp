<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['encryption_key'] = config_item('encryption_key');  // reuse global key
$config['driver']         = 'openssl';
$config['cipher']         = 'aes-256';
$config['mode']           = 'ctr';
