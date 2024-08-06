<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Index controller, Default controller 
 */
class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //-- Loads
        $this->load->helper('utils');
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
        $start_date = date('01-m-Y');
        $middle_date = date('d-m-Y', strtotime($start_date."+14days"));
        $today_date = date('d-m-Y');
        if($middle_date > $today_date) {
            $data['params']['date1'] = date('01-m-Y');
            $data['params']['date2'] = date('d-m-Y');
        }else {
            $data['params']['date1'] = date('16-m-Y');
            $data['params']['date2'] = date('d-m-Y');
        }
        $diff = strtotime($data['params']['date2']) - strtotime($data['params']['date1']);
        $data['params']['days'] = abs(round($diff/86400));
        $data['contracts'] = $this->Dashboard_model->getNumberOfContracts();
        $data['total_ga'] = $this->Dashboard_model->getTotalGa();
        $data['geo_areas'] = $this->Dashboard_model->getGeoAreas();
        $data['nomination_counts'] = $this->Dashboard_model->getNominationCounts($data['params']);
        $data['dcq_counts'] = $this->Dashboard_model->getDcqContractsCounts();
        $data['dcq'] = $this->Dashboard_model->getSumOfDcqValue();        
        $data['page']['content'] = $this->load->view('dashboard/dashboard', $data, TRUE);
        $this->load->view('template/template', $data);
    }

    /**
     * GA waise nomination and allocation counts
     */
    public function dashboardExt()
    {
        $data['params'] = $this->input->post();
        $data['geo_areas'] = $this->Dashboard_model->getGeoAreas();
        $data['nomination_counts'] = $this->Dashboard_model->getNominationCounts($data['params']);
        $data['dcq_counts'] = $this->Dashboard_model->getDcqContractsCounts();

        $this->load->view('dashboard/dashboard_ext', $data);
    }
}