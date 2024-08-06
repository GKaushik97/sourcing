<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard controller
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }
    
    /**
     * Index function
     */
    public function index()
    {
        $data['page'] = array(
            'title' => 'Dashboard Counts',
            'layout' => 1,
        );
        $data['page']['content'] = $this->load->view('dashboard/dashboard', $data, TRUE);
        $this->load->view('template/template', $data);
    }
    //
    public function dashboardExt()
    {
        $data['params'] = $this->input->post();
        $data['geo_areas'] = $this->Dashboard_model->getGeoAreas();
        $data['nomination_counts'] = $this->Dashboard_model->getNominationCounts($data['params']);
        $data['dcq_counts'] = $this->Dashboard_model->getDcqContractsCounts();
        $this->load->view('dashboard/dashboard_ext', $data);
    }
}