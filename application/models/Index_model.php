<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*
    *Status wise counts
    */
    public function getStatusData(){
        return $this->db->select('status, COUNT(id) as count')
        ->from('profiles')
        ->group_by(array('status'))
        ->get()->result_array();
    }
}