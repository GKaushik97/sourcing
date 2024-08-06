<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contract controller
 */
class GasSource extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('file');
        $this->load->model('States_model');
        $this->load->model('Supplier_model');
        $this->load->model('GasSource_model');
    }
    
    /**
     * Index function
     */
    public function add_nomination()
    {
        $data['page'] = array(
            'title' => 'Dashboard',
            'layout' => 1,
        );
        $data['states'] = $this->States_model->getAllStates();
        $data['suppliers'] = $this->Supplier_model->getAllSupplier();
        $data['page']['content'] = $this->load->view('gas_source/gas_source', $data, true);
        $this->load->view('template/template', $data);
    } 

    /**
     * Geo Area Filter Using State Id
     */ 
    public function geoAreaFilter()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('gas_source/geo_area_filter', $data);
    }

    /**
     * Index Body
     */ 
    public function index_body()
    {
        $nomination_date = date('Y-m-d', strtotime($this->input->post('nomination_date')));
        if($nomination_date == date('Y-m-d') || $nomination_date == date('Y-m-d', strtotime('+1days')) || $nomination_date == date('Y-m-d', strtotime('+2days'))) {
            $data['params'] = $this->input->post();
        }else {
            $data['states'] = $this->States_model->getAllStates();
            $data['suppliers'] = $this->Supplier_model->getAllSupplier();
            $this->load->view('gas_source/gas_source', $data);
            echo "Please choose Proper Dates(Today, Tomorrow or the Next Day)";
        }
        if(isset($data['params'])){
            $data['states'] = $this->States_model->getAllStates();
            $data['suppliers'] = $this->Supplier_model->getAllSupplier();
            if($data['params']['state'] > 0){
                $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('state')); 
            }
            $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
            $data['ga_nomination'] = $this->GasSource_model->getGaNomination($data['params']);   
            print "<pre>";
            print_r($data['ga_nomination']);
            print "</pre>";
            print $this->db->last_query();
            $data['allocation_history'] = $this->GasSource_model->getAllocationHistory($data['params']);
            $this->load->view('gas_source/gas_source_body', $data);
        }
    }

    public function nomination_insert()
    {   
       
        //Checking the data to be Inserted 
        if ($this->input->post('dcq_value')['IN'] && !empty($this->input->post('dcq_value')['IN'])) {
            foreach ($this->input->post('dcq_value')['IN'] as $con_id => $value) {
                if ($value > 0 and  $this->input->post('nomination_unit')['IN'][$con_id] > 0) {
                $nominations[] = array(
                    'state' => $this->input->post('state_ext'),
                    'ga' => $this->input->post('ga_ext'),
                    'contract' => $con_id,
                    'source_date' => date('Y-m-d'),
                    'nomination_qty' => $value,
                    'nomination_unit' => $this->input->post('nomination_unit')['IN'][$con_id],
                    'nomination_at' => date('Y-m-d H:i:s'),
                    'nomination_by' => $this->session->userdata('user')['id'],
                );  
                }
            }
            if (isset($nominations) and !empty($nominations)) {
                $this->GasSource_model->nomination_insert($nominations);
                print ("contract Nomination (SCM) Inserted Successfully.");
            }
        }
        //Checking the data to be Updated
        if (isset($_POST['dcq_value']['UP']) && !empty($this->input->post('dcq_value')['UP'])) {
            foreach ($this->input->post('dcq_value')['UP'] as $contract_id => $update_value) {
                if ($update_value > 0 and  $this->input->post('nomination_unit')['UP'][$contract_id] > 0) {
                    $nomination_update[] = array(
                        'state' => $this->input->post('state_ext'),
                        'ga' => $this->input->post('ga_ext'),
                        'contract' => $contract_id,
                        'source_date' => date('Y-m-d'),
                        'nomination_qty' => $update_value,
                        'nomination_unit' => $this->input->post('nomination_unit')['UP'][$contract_id],
                        'nomination_at' => date('Y-m-d H:i:s'),
                        'nomination_by' => $this->session->userdata('user')['id'],
                    );
                }
                print "<pre>";
                print_r($nomination_update);
                print "</pre>";
                exit();

            }
            if (isset($nomination_update) and !empty($nomination_update)) {
                $this->GasSource_model->nomination_update($nomination_update);
                print ("contract Nomination (SCM) Updated Successfully.");
            }
        }
    }
    


    /**
     * Add Consumption
     */
    public function addConsumption()
    {
        $data['page'] = array(
            'title' => 'Dashboard',
            'layout' => 1,
        );
        $data['states'] = $this->States_model->getAllStates();
        $data['page']['content'] = $this->load->view('gas_source/consumption', $data, true);
        $this->load->view('template/template', $data);
    }
    /**
     * Geo Area Filter Using State Id
     */ 
    public function stateGaFilter()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('gas_source/ga_consumption_filter', $data);
    }
    /**
     * Consumption Body
     */ 
    public function consumptionBody()
    {
        $data['params'] = $this->input->post();
        $data['states'] = $this->States_model->getAllStates();
        if($data['params']['state'] > 0){
            $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('state'));
        }
        $this->load->view('gas_source/consumption_body', $data);
    }
    /**
     * Allocate consumption
     */ 
    public function allocateConsumption()
    {
        $data['params'] = $this->input->post();
        $data['states'] = $this->States_model->getAllStates();
        if($data['params']['state'] > 0){
            $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('state'));
        }
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $data['allocation_history'] = $this->GasSource_model->getAllocationHistory($data['params']);
        $this->load->view('gas_source/consumption_body', $data);
    }
    public function allocateConsumptionExt()
    {
        if (isset($_POST['dcq_value']) && !empty($_POST['dcq_value']))
        {
            $params = $this->input->post();
            if($this->GasSource_model->getConsumptionDetails($params)){
                $consumption = array(
                    'quantity' => $this->input->post('consumption'),
                    'unit' => $this->input->post('consumption'),
                    'gcv' => $this->input->post('gcv'), 
                );
                $this->GasSource_model->updateConsumption($consumption,$params);
            }
            else {
                $consumption = array(
                    'state' => $this->input->post('state'),
                    'ga' => $this->input->post('ga'),
                    'consumption_date' => date('Y-m-d'),
                    'quantity' => $this->input->post('consumption'),
                    'unit' => $this->input->post('consumption'),
                    'gcv' => $this->input->post('gcv'),
                    'added_at' => date('Y-m-d H:i:s'),
                    'added_by' => $this->session->userdata('user')['id'],
                );
                $this->GasSource_model->insertConsumption($consumption); 
            }
            foreach ($_POST['dcq_value'] as $con_id => $values) {
                $nomination = array(
                    'allocation_qty' => $values,
                    'allocation_unit' => $values,
                    'gcv' => $this->input->post('gcv'),
                    'allocation_at' => date('Y-m-d H:i:s'),
                    'allocation_by' => $this->session->userdata('user')['id'],
                );
                $this->GasSource_model->updateNomination($nomination, $params, $con_id);
            }
            print ("contract Consumption (SCM) Allocated Successfully.");
        }
    }
}