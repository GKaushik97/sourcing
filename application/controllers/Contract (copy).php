<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contract controller
 */
class Contract extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Contract_model');
        $this->load->model('ContractTypes_model');
        $this->load->model('States_model');
        $this->load->model('Supplier_model');
        $this->load->helper('file');
    }
    
    /**
     * Index function
     */
    public function index()
    {
        $data['params'] = array('rows' => 10, 'pageno' =>1,'sort_by' => 'added_at', 'sort_order' => 'DESC','keywords' => '', 'state' => '', 'geo_area' => '');
        $data['tRecords'] = $this->Contract_model->getContractListNum($data['params']);
        $data['states'] = $this->States_model->getAllStates();
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        $data['contract'] = $this->Contract_model->getContractList($data['params']);
        $data['page'] = array(
            'title' => 'Contract',
            'content' => $this->load->view('contract/contract', $data, TRUE),
        );
        $this->load->view('template/template', $data);
    } 
    /**
     * Index Body
     */ 
    public function index_body()
    {
        $data['params'] = $this->input->post();
        $data['tRecords'] = $this->Contract_model->getContractListNum($data['params']);
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        $data['states'] = $this->States_model->getAllStates();
        if($data['params']['state'] > 0){
            $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('state'));
        }
        $data['contract'] = $this->Contract_model->getContractList($data['params']);
        $this->load->view('contract/contract_body', $data);
    }

    /**
     * To add the Contract
     */    
    public function addContract()
    {
        $data['supplier'] = $this->Supplier_model->getAllSuppliers();
        $data['states'] = $this->States_model->getAllStates();
        $data['contract_types'] = $this->ContractTypes_model->getAllContractTypes();
        $this->load->view('contract/add_contract', $data);
    }

    /**
     * To Insert the Contract
     */
    public function insertContract()
    {
        $this->form_validation->set_rules('state','State','trim|required');
        if($this->input->post('state') != '') {
            $this->form_validation->set_rules('ga', 'GA', 'required');
        }
        $this->form_validation->set_rules('supplier','Supplier','trim|required');
        $this->form_validation->set_rules('code','Code','trim|required');
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('type','Type','trim|required');
        $this->form_validation->set_rules('start_date','Start Date','trim|required');
        $this->form_validation->set_rules('end_date','End Date','trim|required');
        $this->form_validation->set_rules('dcq','DCQ','trim|required|numeric');
        if($this->input->post('dcq') != '') {
            $this->form_validation->set_rules('price_unit','Unit','trim|required');
        }
        $this->form_validation->set_rules('mgo','MGO','trim|required|numeric');
        $this->form_validation->set_rules('excess_limit','Excess Limit','trim|required|numeric');
        $this->form_validation->set_rules('price','Price','trim|required|numeric');
        $this->form_validation->set_rules('overdraw_price','Overdraw Price','trim|required|numeric');
        $this->form_validation->set_rules('underdraw_price','UnderDraw Price','trim|required|numeric');
        $this->form_validation->set_rules('transport_price','Transport Price','trim|required|numeric');
        if($this->form_validation->run() == FALSE) {
            $data['states'] = $this->States_model->getAllStates();
            $data['geo_areas'] = ($this->input->post('state') > 0) ? $this->States_model->getStateGeoAreas($this->input->post('state')) : '' ;
            $data['supplier'] = $this->Supplier_model->getAllSuppliers();
            $data['contract_types'] = $this->ContractTypes_model->getAllContractTypes();
            $this->load->view('contract/add_contract', $data);
        }else {
            //To upload a document
            if(isset($_FILES['document']) and !empty($_FILES['document'])) {
                $config['upload_path'] = DOCUMENT_ROOT.'assets/documents/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['max_size'] = 2048;
                $config['file_name'] = 'document_'.time();
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('document')) {
                    $upload_data = $this->upload->data();
                    $file = $upload_data['file_name'];
                    chmod(DOCUMENT_ROOT . 'assets/documents/' . $file, 0777);
                }else {
                    $file = '';
                }
            }
            $contract_data = array(
                'state' => $this->input->post('state'),
                'ga' => $this->input->post('ga'),
                'supplier' => $this->input->post('supplier'),
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                'dcq' => $this->input->post('dcq'),
                'price_unit' => $this->input->post('price_unit'),
                'mgo' => $this->input->post('mgo'),
                'excess_limit' => $this->input->post('excess_limit'),
                'price' => $this->input->post('price'),
                'overdraw_price' => $this->input->post('overdraw_price'),
                'underdraw_price' => $this->input->post('underdraw_price'),
                'transport_price' => $this->input->post('transport_price'),
                'status' => 1,
                'document' => isset($file) ? $file : '',
                'added_at' => date('Y-m-d H:i:s'),
                'added_by' => $this->session->userdata('user')['id'],
            );
            $insert_contract = $this->Contract_model->insertContract($contract_data);
            if($insert_contract) {
                $alert = array('color' => 'success', 'msg' => "Inserted SuccessFully");
            }else {
                $alert = array('color' => 'danger', 'msg' => "Error in Inserting");
            }
            $this->load->view('alert_modal', $alert);
        }
    }

    /**
     * To get the GA using State Id
     */   
    public function getGeoAreas()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('contract/geo_areas', $data);
    }

    /**
     * To Update the GA 
     */ 
    public function getGeoAreasUpdate()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('contract/edit_geo_areas', $data);
    }
    /**
     * Geo_Area Filter Body
     */ 
    public function geoAreaFilter()
    {
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($this->input->post('id'));
        $this->load->view('contract/geo_areas_filter', $data);
    }

    /**
     * To Edit the Contract
     */ 
    public function editContract()
    {
        $id = $this->input->get('id'); 
        $data['contract'] = $this->Contract_model->getContractById($id);
        $data['geo_areas'] = $this->States_model->getStateGeoAreas($data['contract']['state']);
        $data['supplier'] = $this->Supplier_model->getAllSuppliers();
        $data['states'] = $this->States_model->getAllStates();
        $data['contract_types'] = $this->ContractTypes_model->getAllContractTypes();
        $this->load->view('contract/edit_contract', $data);
    }
    /**
     * To Update the Contract
     */ 
    public function updateContract()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('state','State','trim|required');
        if($this->input->post('state') != ''){
            $this->form_validation->set_rules('ga', 'GA', 'trim|required');
        }
        $this->form_validation->set_rules('supplier','Supplier','trim|required');
        $this->form_validation->set_rules('code','Code','trim|required');
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('type','Type','trim|required');
        $this->form_validation->set_rules('start_date','Start Date','trim|required');
        $this->form_validation->set_rules('end_date','End Date','trim|required');
        $this->form_validation->set_rules('dcq','DCQ','trim|required|numeric');
        if($this->input->post('dcq') != '') {
            $this->form_validation->set_rules('price_unit','Unit','trim|required');
        }
        $this->form_validation->set_rules('mgo','MGO','trim|required|numeric');
        $this->form_validation->set_rules('excess_limit','Excess Limit','trim|required|numeric');
        $this->form_validation->set_rules('price','Price','trim|required|numeric');
        $this->form_validation->set_rules('overdraw_price','Overdraw Price','trim|required|numeric');
        $this->form_validation->set_rules('underdraw_price','UnderDraw Price','trim|required|numeric');
        if($this->form_validation->run() == FALSE) {
            $data['states'] = $this->States_model->getAllStates();
            $data['geo_areas'] = ($this->input->post('state') > 0) ? $this->States_model->getStateGeoAreas($this->input->post('state')) : array() ;
            $data['supplier'] = $this->Supplier_model->getAllSuppliers();
            $data['contract_types'] = $this->ContractTypes_model->getAllContractTypes();
            $this->load->view('contract/edit_contract', $data);
        }else {
            $update_contract_data = array(
                'state' => $this->input->post('state'),
                'ga' => $this->input->post('ga'),
                'supplier' => $this->input->post('supplier'),
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                'dcq' => $this->input->post('dcq'),
                'price_unit' => $this->input->post('price_unit'),
                'mgo' => $this->input->post('mgo'),
                'excess_limit' => $this->input->post('excess_limit'),
                'price' => $this->input->post('price'),
                'overdraw_price' => $this->input->post('overdraw_price'),
                'underdraw_price' => $this->input->post('underdraw_price'),
                'transport_price' => $this->input->post('transport_price'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user')['id'],
            );
            $update_contract = $this->Contract_model->updateContract($update_contract_data, $id);
            if($update_contract) {
                $alert = array('color' => 'success', 'msg' => "Updated SuccessFully");
            }else {
                $alert = array('color' => 'danger', 'msg' => "Error in Updating");
            }
            $this->load->view('alert_modal', $alert);
        }
    }

    /**
     * To Export the Contract Data in CSV
     */ 
    public function getContractExport()
    {
        $data['params'] = $this->input->get();
        $headers = ['Contract Code','Contract Name','MGO','DCQ','Status','State','Geo Area'];
        $contract_export = $this->Contract_model->getContractExport($data['params']);
        $this->load->library('Exporter');
        $csv_data = array(
            'file_name' => 'contract_'.time(),
            'headers' => $headers,
            'content' => $contract_export
        );
        $this->exporter->toCSV($csv_data);
    }

    /**
     * To get the Contract Details using ID
     */ 
    public function getContractById()
    {
        $id = $this->input->get('id'); 
        $data['contract_details'] = $this->Contract_model->getContractById($id);
        $this->load->view('contract/view_contract', $data);
    }

    /**
     * To Change the Contract Status
     */ 
    public function changeContractStatus()
    {
        $id=$this->input->post('id');
        $contract_status = array(
            'status' => $this->input->post('status'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $status_update = $this->Contract_model->updateContract($contract_status, $id);
        if($status_update) {
            $alert = array('color' => 'success', 'msg' => 'Status updated');
        }else {
            $alert = array('color' => 'danger', 'msg' => 'Error in Updating');
        }
        $this->session->set_flashdata('flag', $alert);
    }
}