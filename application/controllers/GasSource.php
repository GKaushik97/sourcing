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
        // Check module access
        $this->userlibrary->checkModuleAccess('nmad');
        $data['states'] = $this->States_model->getAllStates();
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        $data['page'] = array(
            'title' => 'Add Nomination',
            'content' => $this->load->view('gas_source/gas_source', $data, true),
        );
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
        $data['params'] = $this->input->post();
        $data['states'] = $this->States_model->getAllStates();
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        if($data['params']['state'] > 0){
            $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('state')); 
        }
        $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
        $data['ga_nomination'] = $this->GasSource_model->getGaNomination($data['params']);   
        $first_day = date('Y-m-01');
        if(date('Y-m-d',strtotime($this->input->post('nomination_date'))) > date('Y-m-d',strtotime($first_day.'+14days'))) {
            $data['params']['from_date'] = date('Y-m-d',strtotime($first_day.'+15days'));
            $data['params']['to_date'] = date('Y-m-t');
            $tot_allocation = $this->GasSource_model->getGaAllocationTotal($data['params']);
            foreach($tot_allocation as $key => $quantity) {
                $nom_unit_scm = $nom_unit_mmbtu = 0;
                foreach ($quantity as $key1 => $value) {
                    if($value['nomination_unit'] == 2) {
                        $nom_unit_mmbtu = round((($value['nom_qty'] * 252000)/9294.11),2);
                    }else {
                        $nom_unit_scm = $value['nom_qty'];
                    }
                    $data['tot_nomination'][$value['contract']] = round(($nom_unit_mmbtu + $nom_unit_scm),2);
                    $data['tot_alloc'][$value['contract']] = $value['alloc_qty'];
                }
            }
        }else {
            $data['params']['from_date'] = date('Y-m-01');
            $data['params']['to_date'] = date('Y-m-d',strtotime($first_day.'+14days'));
            $data['tot_consumption'] = $this->GasSource_model->getGaConsumptionTotal($data['params']); 
            $data['tot_allocation'] = $this->GasSource_model->getGaAllocationTotal($data['params']);
        }
        $data['allocation_history'] = $this->GasSource_model->getAllocationHistory($data['params']);
        $this->load->view('gas_source/gas_source_body', $data);
    }

    public function nomination_insert()
    {   
        //Checking the data to be Inserted 
        if (isset($_POST['dcq_value']['IN']) && !empty($this->input->post('dcq_value')['IN'])) {
            $sum_value = 0;
            foreach ($this->input->post('dcq_value')['IN'] as $con_id => $value) {
                $sum_value += $value;
            }
            if($sum_value > 0){
                foreach ($this->input->post('dcq_value')['IN'] as $con_id => $value) {
                    if ($value > 0 and  $this->input->post('nomination_unit')['IN'][$con_id] > 0) {
                        $nominations[] = array(
                            'state' => $this->input->post('state_ext'),
                            'ga' => $this->input->post('ga_ext'),
                            'contract' => $con_id,
                            'source_date' => date('Y-m-d',strtotime($this->input->post('nomination_date'))),
                            'nomination_qty' => $value,
                            'nomination_unit' => isset($this->input->post('nomination_unit')['IN'][$con_id]) ? $this->input->post('nomination_unit')['IN'][$con_id] : '' ,
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
            else {
                print "Please enter values.";
            }
        }
        //Checking the data to be Updated
        if (isset($_POST['dcq_value']['UP']) && !empty($this->input->post('dcq_value')['UP'])) {
            $geo_nomination = $this->GasSource_model->getGaNominationById($_POST['update_id']['UP']);
            $sum_value = 0;
            foreach ($this->input->post('dcq_value')['UP'] as $con_id => $value) {
                $sum_value += $value;
            }
            if($sum_value > 0){
                foreach ($this->input->post('dcq_value')['UP'] as $contract_id => $update_value) {
                    if($update_value != $geo_nomination[$contract_id]['nomination_qty'] OR $this->input->post('nomination_unit')['UP'][$contract_id] != $geo_nomination[$contract_id]['nomination_unit']) {
                        if ($update_value > 0) {
                            $nomination_update[] = array(
                                'id' => isset($this->input->post('update_id')['UP'][$contract_id]) ? $this->input->post('update_id')['UP'][$contract_id] : '',
                                'nomination_qty' => $update_value,
                                'nomination_unit' => isset($this->input->post('nomination_unit')['UP'][$contract_id]) ? $this->input->post('nomination_unit')['UP'][$contract_id] : '',
                            );
                        }
                    }
                }  
                if (isset($nomination_update) and !empty($nomination_update)) {
                    $this->GasSource_model->nomination_update($nomination_update);
                    print ("contract Nomination (SCM) Updated Successfully.");
                }else {
                    echo "The Same values Cannot be Updated";
                }
            }
            else {
                print "Please enter values.";
            }
        }
    }
    


    /**
     * Add Consumption
     */
    public function addConsumption()
    {
        // Check module access
        $this->userlibrary->checkModuleAccess('csad');
        $data['states'] = $this->States_model->getAllStates();
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        //$data['page']['content'] = $this->load->view('gas_source/consumption', $data, true);
        $data['page'] = array(
            'title' => 'Add Consumption',
            'content' => $this->load->view('gas_source/consumption', $data, true),
        );
        $this->load->view('template/template', $data);
    }
    /**
     * Geo Area Filter Using State Id
     */ 
    public function stateGaFilter()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('gas_source/consumption_ga_filter', $data);
    }
    /**
     * Consumption Body
     */ 
    public function consumptionBody()
    {
        $data['params'] = $this->input->post();
        $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
        $data['consumption_details'] = $this->GasSource_model->getConsumptionDetails($data['params']);
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $data['allocation_history'] = $this->GasSource_model->getAllocationHistory($data['params']);
        $this->load->view('gas_source/consumption_allocation_details', $data);
    }
    /**
     * Consumption Body ext
     */ 
    public function consumptionBodyExt()
    {
        $data['params'] = $this->input->post();
        $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $this->load->view('gas_source/consumption_allocation_form', $data);
    }
    public function allocateConsumptionExt()
    {
        if (isset($_POST['allocation']) && !empty($_POST['allocation']))
        {
            $data['params'] = $this->input->post();
            $consumption = $this->input->post('consumption');
            $total_allocation = 0;
            foreach ($_POST['allocation'] as $cid => $value) {
              $total_allocation += $value['qty'];   
            }
            if($consumption == $total_allocation){
                $params = $this->input->post();
                if($this->GasSource_model->getConsumptionDetails($params)){
                    $consumption = array(
                        'quantity' => $this->input->post('consumption'),
                        'gcv' => $this->input->post('gcv'), 
                    );
                    $this->GasSource_model->updateConsumption($consumption,$params);
                }
                else {
                    $consumption = array(
                        'state' => $this->input->post('state'),
                        'ga' => $this->input->post('ga'),
                        'supplier' => $this->input->post('supplier'),
                        'consumption_date' => date('Y-m-d',strtotime($this->input->post('selected_date'))),
                        'quantity' => $this->input->post('consumption'),
                        'unit' => 1,
                        'gcv' => $this->input->post('gcv'),
                        'added_at' => date('Y-m-d H:i:s'),
                        'added_by' => $this->session->userdata('user')['id'],
                    );
                    $this->GasSource_model->insertConsumption($consumption); 
                }
                foreach ($_POST['allocation'] as $con_id => $values) {
                    $nomination = array(
                        'allocation_qty' => $values['qty'],
                        'allocation_unit' => 1,
                        'gcv' => $this->input->post('gcv'),
                        'allocation_at' => date('Y-m-d H:i:s'),
                        'allocation_by' => $this->session->userdata('user')['id'],
                    );
                    $this->GasSource_model->updateNomination($nomination, $params, $con_id);
                }
                $data['alert'] = array('color' => 'text-success', 'msg' => "Contract Consumption (SCM) Allocated Successfully.");
            }
            else {
                $data['alert'] = array('color' => 'text-danger', 'msg' => "Sum of all contracts allocation value must be equal to the consumption value.");           
            }
        }
        else {
            $data['alert'] = array('color' => 'text-danger', 'msg' => "Please enter allocation values.");
        }
        $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
        $data['consumption_details'] = $this->GasSource_model->getConsumptionDetails($data['params']);
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $data['allocation_history'] = $this->GasSource_model->getAllocationHistory($data['params']);
        $this->load->view('gas_source/consumption_allocation_details', $data);
    }
    /**
     * Reports
     */
    public function reports()
    {
        $data['states'] = $this->States_model->getAllStates();
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        $data['page'] = array(
            'title' => 'Report',
            'content' => $this->load->view('gas_source/reports', $data, true),
        );
        $this->load->view('template/template', $data);
    }
    /**
     * Geo Area Filter Using State Id
     */ 
    public function stateGaReportFilter()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('gas_source/reports_ga_filter', $data);
    }
    /**
     * Reports Body
     */ 
    public function reportsBody()
    {
        $data['params'] = $this->input->post();
        $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
        $data['nominations'] = $this->GasSource_model->getGasSourceReportsData($data['params']);
        $data['consumptions'] = $this->GasSource_model->getGasSourceConsumptionData($data['params']);
        $this->load->view('gas_source/reports_body', $data);
    }
    /**
     * Change Details
     */ 
    public function changeDetails()
    {
        $data['params'] = $this->input->post();
        $data['states'] = $this->GasSource_model->getStates();
        $data['gas'] = $this->GasSource_model->getGas();
        $data['suppliers'] = $this->GasSource_model->getSuppliers();
        $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
        $data['consumption_details'] = $this->GasSource_model->getConsumptionDetails($data['params']);
        $this->load->view('gas_source/change_nomination_details', $data);
    }
    public function updateNominationDetails()
    {
        $data['params'] = $this->input->post();
        if(isset($data['params']['nomination']) && !empty($data['params']['nomination'])){
            foreach ($data['params']['nomination'] as $key => $value) {
                if($value['qty'] > 0){
                    if($this->GasSource_model->getNominationData($data['params'],$key)){
                        $update_nominations[] = array(
                            'id' => $value['id'],
                            'nomination_qty' => $value['qty'],
                            'nomination_unit' => $value['unit'],
                        );
                    }
                    else {
                        $nominations[] = array(
                            'state' => $this->input->post('state'),
                            'ga' => $this->input->post('ga'),
                            'contract' => $key,
                            'source_date' => date('Y-m-d',strtotime($this->input->post('selected_date'))),
                            'nomination_qty' => $value['qty'],
                            'nomination_unit' => $value['unit'],
                            'nomination_at' => date('Y-m-d H:i:s'),
                            'nomination_by' => $this->session->userdata('user')['id'],
                        );
                    }
                }   
            }
            if (isset($nominations) and !empty($nominations)) {
                $this->GasSource_model->nomination_insert($nominations);
            }
            if (isset($update_nominations) and !empty($update_nominations)) {
                $this->GasSource_model->nomination_update($update_nominations);
            }
            //
            $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
            $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
            $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
            $data['consumption_details'] = $this->GasSource_model->getConsumptionDetails($data['params']);
            $this->load->view('gas_source/change_consumption_details', $data);
        }
    }
    public function allocateConsumptionDetails()
    {
        $data['params'] = $this->input->post();
        $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
        $this->load->view('gas_source/change_allocation_details', $data);
    }
    public function updateAllocationDetails()
    {
        if (isset($_POST['allocation']) && !empty($_POST['allocation']))
        {
            $data['params'] = $this->input->post();
            $consumption = $this->input->post('consumption');
            $total_allocation = 0;
            foreach ($_POST['allocation'] as $cid => $value) {
              $total_allocation += $value['qty'];   
            }
            if($total_allocation > 0){
                if($consumption == $total_allocation){
                    $params = $this->input->post();
                    if($this->GasSource_model->getConsumptionDetails($params)){
                        $consumption = array(
                            'quantity' => $this->input->post('consumption'),
                            'gcv' => $this->input->post('gcv'), 
                        );
                        $this->GasSource_model->updateConsumption($consumption,$params);
                    }
                    else {
                        $consumption = array(
                            'state' => $this->input->post('state'),
                            'ga' => $this->input->post('ga'),
                            'supplier' => $this->input->post('supplier'),
                            'consumption_date' => date('Y-m-d',strtotime($this->input->post('selected_date'))),
                            'quantity' => $this->input->post('consumption'),
                            'unit' => 1,
                            'gcv' => $this->input->post('gcv'),
                            'added_at' => date('Y-m-d H:i:s'),
                            'added_by' => $this->session->userdata('user')['id'],
                        );
                        $this->GasSource_model->insertConsumption($consumption); 
                    }
                    foreach ($_POST['allocation'] as $con_id => $values) {
                        $nomination = array(
                            'allocation_qty' => $values['qty'],
                            'allocation_unit' => 1,
                            'gcv' => $this->input->post('gcv'),
                            'allocation_at' => date('Y-m-d H:i:s'),
                            'allocation_by' => $this->session->userdata('user')['id'],
                        );
                        $this->GasSource_model->updateNomination($nomination, $params, $con_id);
                    }
                    $data['alert'] = array('color' => 'text-success', 'msg' => "Contract Consumption (SCM) Allocated Successfully.");
                }
                else {
                    $data['alert'] = array('color' => 'text-danger', 'msg' => "Sum of all contracts allocation value must be equal to the consumption value.");           
                }
            }
            else {
                $data['alert'] = array('color' => 'text-danger', 'msg' => "Please enter allocation values.");           
            }
        }
        else {
            $data['alert'] = array('color' => 'text-danger', 'msg' => "Please enter allocation values.");
        }
        $data['contracts'] = $this->GasSource_model->getGaContracts($data['params']);  
        $data['nominated_contracts'] = $this->GasSource_model->getNominatedContracts($data['params']);
        $data['nominated_data'] = $this->GasSource_model->getTotalNominatedValue($data['params']);
        $data['consumption_details'] = $this->GasSource_model->getConsumptionDetails($data['params']);
        $this->load->view('gas_source/change_allocation_details', $data);
    }
}