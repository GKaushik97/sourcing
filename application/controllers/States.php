<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * States Controller
 */ 
class States extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('States_model');
		// Check module access
        $this->userlibrary->checkModuleAccess('stal');
	}

	/**
	 * To get the States
	 */ 
	public function index()
	{
		$data['states'] = $this->States_model->getAllStates();
		$data['page'] = array(
            'title' => 'States',
            'content' => $this->load->view('states/states', $data, TRUE),
        );
		$this->load->view('template/template', $data);
	}

	/**
	 * GA list
	 */
	public function geoAreas()
	{
		$data['geo_areas'] = $this->States_model->getAllGeoAreas();
		$data['page'] = array(
            'title' => 'Geo Areas',
            'content' => $this->load->view('states/geo_areas', $data, TRUE),
        );
		$this->load->view('template/template', $data);
	}
}