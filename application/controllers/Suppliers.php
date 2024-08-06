<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Supplier controller
 */
class Suppliers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model');
        $this->load->library('session');
        // Check module access
        $this->userlibrary->checkModuleAccess('spal');
    }
    
    public function index()
    {
        $data['suppliers'] = $this->Supplier_model->getAllSuppliers();
        $data['page'] = array(
            'title' => 'Suppliers',
            'content' => $this->load->view('supplier/supplier', $data, TRUE),
        );
        $this->load->view('template/template', $data);
    }

    /**
     * To add the Supplier
     */ 
    public function addSupplier()
    {
        $this->load->view('supplier/add_supplier');
    }
    /**
     * To Insert the Supplier
     */ 
    public function insertSupplier()
    {
        $this->form_validation->set_rules('name', 'Name','trim|required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('supplier/add_supplier');
        }else {
            $insertSupplier = array(
                'name' => $this->input->post('name'),
                'status' => 1,
                'added_at' => date('Y-m-d H:i:s'),
                'added_by' => $this->session->userdata('user')['id'] 
            );
            $addSupplier = $this->Supplier_model->insertSupplier($insertSupplier);
            if($addSupplier) {
                $alert = array('color' => 'success', 'msg' => 'Added Successfully');
            }else {
                $alert = array('color' => 'danger', 'msg' => 'Error Occured');
            }
            $this->load->view('alert_modal', $alert);
        }
    }

    /**
     * To Edit the Supplier
     */ 
    public function editSupplier() 
    {
        $data['supplier'] = $this->Supplier_model->getSupplierById($this->input->get('id'));
        $this->load->view('supplier/edit_supplier', $data);
    }

    /**
     * To Update the Supplier
     */ 
    public function updateSupplier()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('name','Name','trim|required');
        if($this->form_validation->run() == FALSE) {
            $this->load->view('supplier/edit_supplier');
        }else {
            $editSupplier = array(
                'name' => $this->input->post('name'),
            );
            $updateSupplier = $this->Supplier_model->updateSupplier($editSupplier, $id);
            if($updateSupplier) {
                $alert = array('color' => 'success', 'msg' => 'Updated Successfully');
            }else {
                $alert = array('color' => 'danger', 'msg' => 'Error Occured');
            }
            $this->load->view('alert_modal', $alert);

        }
    }
}