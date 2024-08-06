<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModuleActions_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*
    * Module Actions Count
    */
    public function getModuleActionsNum($params) {
        $this->db->select('count(*) as tRecords');
        $this->db->from('module_actions ma');
        $this->db->join('modules m','m.id=ma.module_id','left');
        if(isset($params['keywords']) && !empty($params['keywords'])){
            $this->db->group_start();
            $this->db->like("ma.action_name", $params['keywords']);
            $this->db->or_like("ma.action_code", $params['keywords']);
            $this->db->group_end();
        }
        $qry = $this->db->get();
        return ($qry->num_rows() > 0) ? $qry->row_array()['tRecords'] : false;
    }
    /*
    *Module Actions list
    */
    public function getModuleActions($params, $cols='*')
    {
        $this->db->select('ma.id, ma.module_id, ma.action_name, ma.action_code, m.name as module');
        $this->db->from('module_actions ma');
        $this->db->join('modules m','m.id=ma.module_id','left');
        if(isset($params['keywords']) && !empty($params['keywords'])){
            $this->db->group_start();
            $this->db->like("ma.action_name", $params['keywords']);
            $this->db->or_like("ma.action_code", $params['keywords']);
            $this->db->group_end();
        }
        $this->db->order_by($params['sortby'], $params['sort_order']);
        $this->db->limit($params['rows'], ($params['pageno']-1)*$params['rows']);
        $qry = $this->db->get();
        return ($qry->num_rows() > 0) ? $qry->result_array() : FALSE;
    }
    /*
    *Get Module Action
    */
    public function getModuleAction($id){
        $qry = $this->db->select('*')->from('module_actions')->where('id',$id)->get();
        if($qry->num_rows()>0){
            return $qry->row_array();
        }
        return false;
    }
    /*
    *Insert Module Action
    */
    public function insertModuleAction($data){
        return $this->db->insert('module_actions', $data);
    }
    /*
    *Update Module Action
    */
    public function updateModuleAction($data,$id){
        return $this->db->where('id', $id)->update('module_actions', $data);
    }
    /*
    *Modules
    */
    public function getModules(){
        return $this->db->select('*')->from('modules')->get()->result_array();
    }
}