
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User model
 */
class User_model extends CI_model
{
    
    public function __construct()
    {
        parent ::__construct();
        $this->load->database();
    }

    /**
     * Check user login
     */
    public function userLogin($username, $password)
    {
        return $this->db->select('u.id, CONCAT(u.fname, " ", u.lname) as name, u.username, u.role, r.rights')
            ->from('users u')
            ->join('roles r', 'u.role = r.id', 'left')
            ->where('u.username', $username)
            ->where('u.password', $password)
            ->where('u.status', 1)
            ->where('u.delete_status', 0)
            ->get()->row_array();
    }

    /**
     * Get rights / actions details
     */
    public function getRights($rights)
    {
        return $this->db->select('action_code')
            ->from('module_actions')
            ->where_in('id', $rights)
            ->get()->result_array();
    }

    /**
     * Get users count
     */
    public function getUserNum($params)
    {
        $this->db->select('*');
        $this->db->where('u.delete_status', 0);
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role', 'left');
        if(isset($params['keywords']) and $params['keywords'] != '') {
            $this->db->group_start();
            $this->db->like("u.fname", $params['keywords']);
            $this->db->or_like("u.lname", $params['keywords']);
            $this->db->or_like("u.username", $params['keywords']);
            $this->db->or_like("u.mobile", $params['keywords']);
            $this->db->or_like("u.email", $params['keywords']);
            $this->db->or_like("r.name", $params['keywords']);
            $this->db->group_end();         
        }
        return $this->db->count_all_results();
    }

    /**
     * Get all users
     */
    public function getAllUsers($params)
    {
        $this->db->select('u.*, r.name as r_name');
        $this->db->where('u.delete_status', 0);
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role', 'left');
        if(isset($params['keywords']) and $params['keywords'] != '') {
            $this->db->group_start();
            $this->db->like("u.fname", $params['keywords']);
            $this->db->or_like("u.lname", $params['keywords']);
            $this->db->or_like("u.username", $params['keywords']);
            $this->db->or_like("u.mobile", $params['keywords']);
            $this->db->or_like("u.email", $params['keywords']);
            $this->db->or_like("r.name", $params['keywords']);
            $this->db->group_end();         
        }
        $this->db->order_by($params['sortby'], $params['sort_order']);
        $this->db->limit($params['rows'], $params['offset']);
        return $this->db->get()->result_array();
    }

    /**
     * Get roles
     */
    public function getRoles()
    {
        return $this->db->get('roles')->result_array();
    }

    /**
     * Insert users
     */
    public function insertUsers($data)
    {
        return $this->db->insert('users', $data) ? true : false;
    }

    /**
     * Get user details
     */
    public function usersEdit($id)
    {
        return $this->db->where('id', $id)->get('users')->row_array();
    }

    /**
     * Uppdate users
     */
    public function updateUsers($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data) ? true : false;
    }

    /**
     * Change status
     */
    public function usersChangeStatus($id, $status)
    {
        $this->db->where('id', $id)->set('status', $status)->update('users');
    }

    /**
     * Change delete status
     */
    public function deleteUser($id)
    {
        $this->db->where('id', $id)->set('delete_status', 1)->update('users');
    }

    /**
     * Get user deatils
     */
    public function usersView($id)
    {
        $this->db->select('u.*, r.name as r_name');
        $this->db->join('roles r', 'r.id = u.role', 'left');
        return $this->db->where('u.id', $id)->get('users u')->row_array();
    }
    
    /**
     * Change Password
     */
    public function user_resetPassword($id)
    {
        $query = $this->db->where('id', $id)->update('users', array("password"=>md5('12345678'), "password_date"=>date('Y-m-d H:i:s')));
        return true;
    }

    // get User
    public function getUser($id)
    {
        $this->db->select('u.*,r.name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id=u.role', 'left');
        return $this->db->where('u.id',$id)->where('delete_status', 0)->get()->row_array();
    } 

    public function check_password($id, $password) {
        $query = $this->db->select('*')->where('id', $id)->where('password', $password)->where('status', 1)->get('users');
        if ($query->num_rows() == 1) {
            $result = $query->row_array();
            return $result;
        }
        return "0";
    }
}