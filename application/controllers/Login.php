<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User controller to manage users
 */
class Login extends CI_controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login
     */
    public function index()
    {
        $this->load->view('user/login');
    }

    /**
     * Login submit
     */
    public function loginSubmit()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        if($this->form_validation->run() == TRUE) {
            //-- Check and login with the database
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $this->load->model('User_model');
            $user_data = $this->User_model->userLogin($username, $password);
            // Login success
            if($user_data) {
                // Get rights
                $actions = [];
                if(!empty($user_data['rights'])) {
                    $rights_array = explode(',', $user_data['rights']);
                    $user_actions = $this->User_model->getRights($rights_array);
                    if($user_actions) {
                        foreach($user_actions as $action) {
                            $actions[] = $action['action_code'];
                        }
                    }
                    $user_data['actions'] = $actions;
                }
                $this->session->set_userdata('user', $user_data);
                redirect('index');
            }
            else {
                $data['message'] = 'Invalid username or password!';
                $this->load->view('user/login', $data);
            }
        }
        else {
            $this->load->view('user/login');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        //-- Remove session data and redirect to login
        $this->session->unset_userdata('user');
        redirect('login');
    }

    public function accessDenied()
    {
        $data['page'] = array(
                'title' => 'Access Denied',
                'content' => $this->load->view('template/block', '', true),
            );
            $this->load->view('template/template', $data);
    }
}