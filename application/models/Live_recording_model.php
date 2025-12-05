<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_recording_model extends CI_Model {
  protected $umsdb;
  protected $table = 'live_recordings';

  public function __construct() {
    parent::__construct();
    $this->umsdb = $this->load->database('umsdb', TRUE);
  }

  public function add($data) {
    $this->umsdb->insert($this->table, $data);
    return $this->umsdb->insert_id();
  }

  public function for_session($session_id) {
    return $this->umsdb->get_where($this->table, ['session_id' => $session_id])->result();
  }
}
