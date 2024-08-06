<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Roles
 */
class Roles extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Roles_model');
        // Check module access
        $this->userlibrary->checkModuleAccess('ural');
    }

    /**
     * Index function
     */
    public function index()
    {
        $data['params'] = array('rows' => 20, 'pageno' => 1, 'sortby' => 'id', 'sort_order' => 'asc', 'keywords' => '');
        $data['params']['tRecords'] = $this->Roles_model->getRolesNum($data['params']);
        $data['roles'] = $this->Roles_model->getRoles($data['params']);
        $data['page'] = array(
            'title' => 'Roles',
            'js' => ['js/roles'],
        );
        $data['page']['content'] = $this->load->view('roles/roles', $data, true);
        $this->load->view('template/template', $data);

    }
    public function rolesBody()
    {
        $data['params'] = $this->input->post();
        $data['params']['tRecords'] = $this->Roles_model->getRolesNum($data['params']);
        $data['roles'] = $this->Roles_model->getRoles($data['params']);
        $this->load->view('roles/roles_body', $data);
    }
    /*
    *Role Add Form
    */
    public function addRole() {
        $this->load->view('roles/role_add');
    }
    /*
    *Role Insertion
    */
    public function insertRole() {
        $data = array(
            'name' => $this->input->post('name'),
            'added_at' => date("Y-m-d H:i:s"),
        );
        if ($this->Roles_model->insertRole($data)) {
            $alert = array('color' => 'success', 'msg' => _("Role Added Successfully."));
        }
        else {
            $alert = array('color' => 'danger', 'msg' => _("Error Occured.. Please try after some time."));
        }
        $this->load->view("alert_modal", $alert);
    }
    /*
    *Role Edit Form
    */
    public function editRole() {
        $data['role'] = $this->Roles_model->getRole($this->input->post('id'));
        $this->load->view('roles/role_edit',$data);
    }
    /*
    *Role Update
    */
    public function updateRole() {
        $data = array(
            'name'=>$this->input->post('name'),
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        if($this->Roles_model->updateRole($data,$this->input->post('id'))){
            $alert = array('color' => 'success', 'msg' => _("Role Updated Successfully."));
        }
        else {
            $alert = array('color' => 'danger', 'msg' => _("Error Occured.. Please try after some time."));
        }
        $this->load->view("alert_modal", $alert);
    }
    /*
    *Manage Rights Form
    */
    public function manageRights() {
        $data['role'] = $this->input->post('id');
        $data['role_rights'] = $this->Roles_model->getRoleRights($this->input->post('id'));
        $data['results'] = $this->Roles_model->getModuleActions();
        $this->load->view('roles/manage_rights',$data);
    }
    /*
    *Manage Role Rights
    */
    public function manageRightsExt() {
        $rights = '';
        if(!empty($this->input->post('rights'))){
            $rights = implode(',', $this->input->post('rights'));
        }
        if($this->Roles_model->updateRoleRights($rights,$this->input->post('id'))){
            $alert = array('color' => 'success', 'msg' => _("Rights Updated Successfully."));
        }
        else {
            $alert = array('color' => 'danger', 'msg' => _("Error Occured.. Please try after some time."));
        }
        $this->load->view("alert_modal", $alert);
    }
    /*
    *Role status update
    */
    public function updateRoleStatus() {
        ($_POST['status'])? $status = 0:$status = 1;
        $data = array(
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        $this->Roles_model->updateRole($data,$this->input->post('id'));
    }
}