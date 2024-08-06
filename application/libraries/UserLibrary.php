<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * UserLibrary
 */
class UserLibrary
{
	// For CodeIgniter super object
    private $_CI;

	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->_CI->load->helper('url');
		$this->checkUser();
	}

	/**
	 * Check login access for the page
	 */
	public function checkUser()
	{
		// Get method form the URL
		$method = $this->_CI->uri->segment(1);
		// Get user session 
		$user = $this->_CI->session->userdata('user');
		//-- Check the user session and login page
		if(strtolower($method) != 'login' and !isset($user)) {
			redirect('login');
		}
	}

	/**
	 * Check super admin
	 */
	public function isSuperAdmin()
	{
		if($this->_CI->session->userdata('user')['role'] == 1) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Check admin
	 */
	public function isAdmin()
	{
		if(($this->_CI->session->userdata('user')['role'] == 1) OR $this->_CI->session->userdata('user')['role'] == 2) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Check user access for the module action
	 */
	public function checkAccess($action_code)
	{
		if(($this->isSuperAdmin()) OR ($this->isAdmin()) OR (in_array($action_code, $this->_CI->session->userdata('user')['actions']))) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Check user access for the module action
	 */
	public function checkModuleAccess($action_code)
	{
		if(($this->isSuperAdmin()) OR ($this->isAdmin()) OR (in_array($action_code, $this->_CI->session->userdata('user')['actions']))) {
			return TRUE;
		}
		else {
			redirect('login/accessDenied');
			exit();
		}
	}

	/**
	 * Check module access
	 */
	public function checkModule()
	{
		return TRUE;
	}
}