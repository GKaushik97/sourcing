<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*
    * Roles Count
    */
    public function getRolesNum($params) {
        $this->db->select('count(*) as tRecords');
        $this->db->from('roles');
        if(isset($params['keywords']) && !empty($params['keywords'])){
            $this->db->group_start();
            $this->db->like("name", $params['keywords']);
            $this->db->group_end();
        }
        $qry = $this->db->get();
        return ($qry->num_rows() > 0) ? $qry->row_array()['tRecords'] : false;
    }
    /*
    *Roles list
    */
    public function getRoles($params, $cols='*')
    {
        $this->db->select('*');
        $this->db->from('roles');
        if(isset($params['keywords']) && !empty($params['keywords'])){
            $this->db->group_start();
            $this->db->like("name", $params['keywords']);
            $this->db->group_end();
        }
        $this->db->order_by($params['sortby'], $params['sort_order']);
        $this->db->limit($params['rows'], ($params['pageno']-1)*$params['rows']);
        $qry = $this->db->get();
        return ($qry->num_rows() > 0) ? $qry->result_array() : FALSE;
    }
    /*
    *Get Role
    */
    public function getRole($id){
        $qry = $this->db->select('*')->from('roles')->where('id',$id)->get();
        if($qry->num_rows()>0){
            return $qry->row_array();
        }
        return false;
    }
    /*
    *Insert Role
    */
    public function insertRole($data){
        return $this->db->insert('roles', $data);
    }
    /*
    *Update Role
    */
    public function updateRole($data,$id){
        return $this->db->where('id', $id)->update('roles', $data);
    }
    /*
    *Get Module Actions
    */
    public function getModuleActions(){
        $qry = $this->db->select('ma.id, ma.module_id, ma.action_name, ma.action_code, m.name as module')->from('module_actions ma')->join('modules m', 'm.id=ma.module_id','left')->get();
        if($qry->num_rows() > 0){
            foreach ($qry->result_array() as $key => $value) {
                $data['modules'][$value['module_id']] = $value['module'];
                $data['actions'][$value['module_id']][] = $value;
            }
            return $data;
        }
        return false;
    }
    public function getRoleRights($id){
        return $this->db->select('rights')->from('roles')->where('id',$id)->get()->row_array();
    }
    /*
    *Update Role Rights
    */
    public function updateRoleRights($rights,$id){
        return $this->db->set('rights',$rights)->where('id', $id)->update('roles');
    }
}