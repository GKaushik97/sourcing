<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * States Model
 */
class States_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get all states
	 */
	public function getAllStates()
	{
		return $this->db->get('state')->result_array();
	}

	/**
	 * Gell GA details
	 */
	public function getAllGeoAreas()
	{
		return $this->db->select('g.*, s.name as state_name')
			->from('ga g')
			->join('state s', 's.id = g.state')
			->get()->result_array();
	}

	/**
	 * get Geo Area By State
	 */ 
	public function getStateGeoAreas($id)
	{
		return $this->db->select('*')->from('ga')->where('state', $id)->get()->result_array();
	}
}