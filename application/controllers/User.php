<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User controller to manage users
 */
class User extends CI_controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        // Check module access
        $this->userlibrary->checkModuleAccess('usal');
    }

    /**
     * Index function
     * List of users
     */
    public function index()
    {
        $data['params'] = array('pageno' => 1, 'rows' => 20, 'offset' => 0, 'sortby' => 'id', 'sort_order' => 'desc', 'keywords' => '');
        $data['params']['tRecords'] = $this->User_model->getUserNum($data['params']);
        $data['users'] = $this->User_model->getAllUsers($data['params']);
        $data['page'] = array(
            'title' => 'User administration',
            'js' => array('js/users'),
            'content' => $this->load->view('user/users', $data, true),
        );
        $this->load->view('template/template', $data);
    }

    public function index_body()
    {
        $data['params'] = array(
            'rows' => $this->input->post('rows'),
            'pageno' => $this->input->post('pageno'),
            'sortby' => $this->input->post('sortby'),
            'sort_order' => $this->input->post('sort_order'),
            'offset' => (($this->input->post('pageno') - 1) * $this->input->post('rows')),
            'keywords' => $this->input->post('keywords'),
        );
        $data['params']['tRecords'] = $this->User_model->getUserNum($data['params']);
        $data['users'] = $this->User_model->getAllUsers($data['params']);
        $this->load->view('user/users_body', $data);
    }

    /**
     * Add user
     */
    public function addUser()
    {
        $data['roles'] = $this->User_model->getRoles();
        $this->load->view('user/add_users', $data);
    }

    /**
     * Insert users
     */
    public function insertUsers()
    {
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|min_length[10]|max_length[12]');

        if ($this->form_validation->run() == TRUE) {
            $data['user_details'] = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password')),
                'role' => $this->input->post('role'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'password_date' => date('Y-m-d H:i:s'),
                'added_at' => date('Y-m-d H:i:s'),
                'added_by' => $_SESSION['user']['id'],
            );
            $insert = $this->User_model->insertUsers($data['user_details']);
            if ($insert) {
                $alert = array('color'=>'success', 'msg' => 'Successfully Inserted!..');
            }
            else {
                $alert = array('color' => 'danger', 'msg' => 'error occured, try again.');
            }
            $this->load->view('alert_modal', $alert);
        }
        else {
            $data['roles'] = $this->User_model->getRoles();
            $this->load->view('user/add_users', $data);
        }
    }

    /**
     * Edit users
     */
    public function usersEdit()
    {
        $id = $this->input->post('id');
        $data['users'] = $this->User_model->usersEdit($id);
        $data['roles'] = $this->User_model->getRoles();
        $this->load->view('user/edit_users', $data);
    }

    /**
     * Update users
     */
    public function updateUsers()
    {

        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|min_length[10]|max_length[12]');
        if ($this->form_validation->run() == true) {
            $id = $this->input->post('id');
            $data['update_details'] = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'role' => $this->input->post('role'),
                'email' => $this->input->post('email'),
                'mobile' => $this->input->post('mobile'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['user']['id'],
            );
            $update = $this->User_model->updateUsers($id, $data['update_details']);
            if ($update) {
                $alert = array('color'=>'success', 'msg' => 'Successfully Updated!..');
            }
            else {
                $alert = array('color' => 'danger', 'msg' => 'error occured, try again.');
            }
            $this->load->view('alert_modal', $alert);
        } else {
            $id = $this->input->post('id');
            $data['roles'] = $this->User_model->getRoles();
            $data['users'] = $this->User_model->usersEdit($id);
            $this->load->view('user/edit_users', $data);
        }
    }

    /**
     * User change status
     */
    public function usersChangeStatus()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $this->User_model->usersChangeStatus($id, $status);
    }

    public function deleteUser()
    {
        $id = $this->input->post('id');
        $this->User_model->deleteUser($id);
    }

    public function usersView()
    {
        $id = $this->input->post('id');
        $data['users_details'] = $this->User_model->usersView($id);
        $this->load->view('user/view_users', $data);
    }

    /**
     * Reset Password
     */
    public function resetPassword()
    {
        $result = $this->User_model->user_resetPassword($_POST['id']);
        if($result) {
            $alert = array('color' => 'success',  'msg' => _("Password Resetted to '12345678' Successfully."));
        }
        else {
            $alert = array('color' => 'danger', 'msg' => _('Error Occured.'));
        }
        $this->session->set_flashdata('flag', $alert);
    }

    /**
     * User profile
     */
    public function profile()
    {
        $id = $this->session->userdata('user')['id'];
        $data['user_details'] = $this->User_model->getUser($id);
        $data['page'] = array(
            'title' => 'Profile',
            'css' => ['template/css/user'],
            'content' => $this->load->view('user/profile', $data, TRUE)
        );
        $this->load->view('template/template', $data);
    }

    /**
     * Change User Password
     */
    public function changePassword()
    {
        $user = $this->session->userdata('user');       
        $data['user'] = $this->User_model->getUser($user['id']);
        $data['page'] = array(
            'title' => 'Change Password',
            'css' => ['template/css/user'],
            'content' => $this->load->view('user/user_change_password', $data, true),
        );
        $this->load->view('template/template', $data);
    }

    /**
     * Update User Password
     */
    public function updatePassword()
    {
        // check form validations
        $id = $this->input->post('id');
        $this->form_validation->set_rules('oldpassword','Old Password','required|callback_password_check');
        $this->form_validation->set_rules('password','New Password','trim|required|min_length[8]|callback_newpassword_check');
        $this->form_validation->set_rules('passconf','Confirm Password','trim|required|matches[password]');
        if($this->form_validation->run() == false) {
            $user = $this->session->userdata('user');       
            $data['user'] = $this->User_model->getUser($user['id']);
            $data['page'] = array(
                'title' => 'Change Password',
                'content' => $this->load->view('user/user_change_password', $data, true),
            );
            $this->load->view('template/template', $data);
        } else {
            $data['password'] = md5($this->input->post('password'));
            $data['password_date'] = date('Y-m-d H:i:s');
            if ($this->User_model->updateUsers($id, $data)) {
                 $alert = array('color' => 'success', 'msg' => 'Password Updated Successfully');
            }
            else {
                $alert = array('color' => 'danger', 'msg' => 'Error Occured in Updating the Password');
            }
            $this->load->view('alert_modal', $alert);
        }
    }
    public function password_check()
    {
        $id = $this->session->userdata('user')['id'];
        $user = $this->User_model->getUser($id);
        if($user['password'] != md5($this->input->post('oldpassword'))){
            $this->form_validation->set_message('password_check','The {field} does not match');
            return false;
        }
        return true;
    }
    public function newpassword_check()
    {
        if($this->input->post('oldpassword') == $this->input->post('password')) {
            $this->form_validation->set_message('newpassword_check','The {field} and the oldpassword should not be the same');
            return false;
        }
        return true;
    }

    public function menuPage()
    {
        $this->load->view('user/menu_page');
    }

    public function candidates()
    {
        $data['page'] = array(
            'title' => 'Candidates',
            'content' => $this->load->view('user/candidate', '', true),
        );
        $this->load->view('template/template', $data);
    }
}