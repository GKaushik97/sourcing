<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ModuleActions
 */
class ModuleActions extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModuleActions_model');
        // Check module access
        $this->userlibrary->checkModuleAccess('maal');
    }

    /**
     * Index function
     */
    public function index()
    {
        $data['params'] = array('rows' => 20, 'pageno' => 1, 'sortby' => 'module_id', 'sort_order' => 'asc', 'keywords' => '');
        $data['params']['tRecords'] = $this->ModuleActions_model->getModuleActionsNum($data['params']);
        $data['module_actions'] = $this->ModuleActions_model->getModuleActions($data['params']);
        $data['page'] = array(
            'title' => 'Module Actions',
            'js' => ['js/module_actions'],
        );
        $data['page']['content'] = $this->load->view('module_actions/module_actions', $data, true);
        $this->load->view('template/template', $data);

    }
    public function moduleActionsBody()
    {
        $data['params'] = $this->input->post();
        $data['params']['tRecords'] = $this->ModuleActions_model->getModuleActionsNum($data['params']);
        $data['module_actions'] = $this->ModuleActions_model->getModuleActions($data['params']);
        $this->load->view('module_actions/module_actions_body', $data);
    }
    /*
    *Module Actions Add Form
    */
    public function addModuleAction() {
        $data['modules'] = $this->ModuleActions_model->getModules();
        $this->load->view('module_actions/module_action_add',$data);
    }
    /*
    *Module Action Insertion
    */
    public function insertModuleAction() {
        $data = array(
            'module_id' => $this->input->post('module_id'),
            'action_name' => $this->input->post('action_name'),
            'action_code' => $this->input->post('action_code'),
            'added_at' => date("Y-m-d H:i:s"),
        );
        if ($this->ModuleActions_model->insertModuleAction($data)) {
            $alert = array('color' => 'success', 'msg' => _("Module Action Added Successfully."));
        }
        else {
            $alert = array('color' => 'danger', 'msg' => _("Error Occured.. Please try after some time."));
        }
        $this->load->view("alert_modal", $alert);
    }
    /*
    *Module Action Edit Form
    */
    public function editModuleAction() {
        $data['modules'] = $this->ModuleActions_model->getModules();
        $data['module_action'] = $this->ModuleActions_model->getModuleAction($this->input->post('id'));
        $this->load->view('module_actions/module_action_edit',$data);
    }
    /*
    *Module Action Update
    */
    public function updateModuleAction() {
        $data = array(
            'module_id' => $this->input->post('module_id'),
            'action_name' => $this->input->post('action_name'),
            'action_code' => $this->input->post('action_code'),
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        if($this->ModuleActions_model->updateModuleAction($data,$this->input->post('id'))){
            $alert = array('color' => 'success', 'msg' => _("Module Action Updated Successfully."));
        }
        else {
            $alert = array('color' => 'danger', 'msg' => _("Error Occured.. Please try after some time."));
        }
        $this->load->view("alert_modal", $alert);
    }
}