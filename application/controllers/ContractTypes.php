<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ContractTypes Controller
 */ 
class ContractTypes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ContractTypes_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		// Check module access
        $this->userlibrary->checkModuleAccess('ctal');
	}

	/**
	 * To get all contrct types
	 */ 
	public function index()
	{
		$data['contract_type'] = $this->ContractTypes_model->getAllContractTypes();	
		$data['tRecords'] = $this->ContractTypes_model->getAllContractTypesNum();
		$data['page'] = array(
            'title' => 'Contract Types',
            'content' => $this->load->view('contract_types/contract_types', $data, TRUE)
        );
		$this->load->view('template/template', $data);
	}
	
	/**
	 * To Add the ContractType
	 */
	public function addContractType()
	{
		$this->load->view('contract_types/add_contract_type');
	} 

	/**
	 * To Insert the ContractType
	 */  
	public function insertContractType()
	{
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE) {
			$this->load->view('contract_types/add_contract_type');
		}else {
			$insert_contract_type = array(
				'name' => $this->input->post('name'),
				'added_at' => date('Y-m-d H:i:s'),
				'added_by' => $this->session->userdata('user')['id'],
			);
			$add_Contract_type = $this->ContractTypes_model->insertContractType($insert_contract_type);
			if($add_Contract_type) {
                $alert = array('color' => 'success', 'msg' => 'Added Successfully');
            }else {
                $alert = array('color' => 'danger', 'msg' => 'Error Occured');
            }
            $this->load->view('alert_modal', $alert);
		}
	}

	/**
	 * To Edit the Contract
	 */ 
	public function editContractType()
	{
        $id = $this->input->get('id');
		$data['contract_type'] = $this->ContractTypes_model->getContractTypeById($id);
		$this->load->view('contract_types/edit_contract_type', $data);
	}

	/**
	 * To Update the Contract Type
	 */
	public function updateContractType()
	{

		$id = $this->input->post('id');
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE) {
			$this->load->view('contract_types/edit_contract_type');
		} else {
			$edit_contract_type = array(
				'name' => $this->input->post('name'),
				'added_by' => $this->session->userdata('user')['id'],
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$update_Contract_type = $this->ContractTypes_model->updateContractType($edit_contract_type, $id);
			if($update_Contract_type) {
                $alert = array('color' => 'success', 'msg' => 'Updated Successfully');
            }else {
                $alert = array('color' => 'danger', 'msg' => 'Error Occured');
            }
            $this->load->view('alert_modal', $alert);
		}
	}

	/**
	 * To delete the Contract
	 */
	public function deleteContractType()
	{
		$id = $this->input->get('id');
		$delete_Contract_type = $this->ContractTypes_model->deleteContractType($id);
		if($delete_Contract_type) {
            $alert = array('color' => 'success', 'msg' => 'Record Deleted');
        }else {
            $alert = array('color' => 'danger', 'msg' => 'Error Occured');
        }
        $this->load->view('alert_modal', $alert);
	}    
}