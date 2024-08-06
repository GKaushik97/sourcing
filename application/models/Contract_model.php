<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Contract-Model
 */

class Contract_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * To get the Total Contractlist
	 */ 
	public function getContractListNum($params)
	{
		$this->db->select('c.id');
		$this->getContractQry($params);
		return $this->db->count_all_results();
	}

	/**
	 * To get the ContractList
	 */
	public function getContractList($params) 
	{
		$this->db->select('c.*,s.name as state_name,g.name as geo_area,sp.name as supplier_name,CONCAT_WS(" ",u.fname,u.lname) as username');
		$this->getContractQry($params);
		$this->db->order_by($params['sort_by'],$params['sort_order']);
		$this->db->limit($params['rows'], ($params['pageno']-1)*$params['rows']);
		return $this->db->get()->result_array();
	} 

	public function getContractQry($params)
	{
		$this->db->from('contract c');
		$this->db->join('state s', 's.id=c.state', 'left');
		$this->db->join('ga g','g.id=c.ga','left');
		$this->db->join('users u','u.id=c.added_by','left');
		$this->db->join('supplier sp', 'sp.id=c.supplier', 'left');
		$this->db->join('contract_type ct','ct.id=c.type', 'left');
		if(isset($params['keywords']) and !empty($params['keywords'])) {
			$this->db->like('c.name', $params['keywords']);
		}
		if(isset($params['state']) and !empty($params['state'])) {
			$this->db->where('c.state', $params['state']);
		}
		if(isset($params['geo_area']) and !empty($params['geo_area'])) {
			$this->db->where('c.ga', $params['geo_area']);
		}
		if(isset($params['name']) and !empty($params['name'])) {
			$this->db->like('c.name', $params['name']);
		}
		if(isset($params['code']) and !empty($params['code'])) {
			$this->db->like('c.code', $params['code']);
		}
		if(isset($params['supplier']) and !empty($params['supplier'])) {
			$this->db->where('c.supplier', $params['supplier']);
		}
		if(isset($params['priority']) and !empty($params['priority'])) {
			$this->db->where('c.priority', $params['priority']);
		}
		if(isset($params['status']) and ($params['status'] != '')) {
			$this->db->where('c.status', $params['status']);
		}
	}

	/**
	 * To insert the Contract
	 */ 
	public function insertContract($data)
	{
		return $this->db->insert('contract', $data);
	} 
	/**
	 * To update the Contract
	 */ 
	public function updateContract($data, $id) {
		return $this->db->where('id', $id)->update('contract', $data);
	}

	/**
	 * Get Contract By ID
	 */
	public function getContractById($id) 
	{
		return $this->db->select('c.*,s.name as state_name,g.name as geo_area,ct.name as contract_type,sp.name as supplier_name,CONCAT_WS(" ",u1.fname,u1.lname) as added_name, CONCAT_WS(" ", u2.fname,u2.lname) as updated_name')
						->from('contract c')
						->join('state s','s.id=c.state','left')
						->join('ga g','g.id=c.ga', 'left')
						->join('contract_type ct', 'ct.id=c.type', 'left')
						->join('supplier sp', 'sp.id=c.supplier', 'left')
						->join('users u1', 'u1.id=c.added_by', 'left')
						->join('users u2', 'u2.id=c.updated_by','left')
						->where('c.id', $id)->get()->row_array();
	}

	/**
	 * Get State,Ga,Supplier by Id
	 */ 
	public function getContractAreasSupplierById($id)
	{
		return $this->db->select('c.state,c.ga,c.supplier,s.name as state_name,g.name as geo_area,sp.name as supplier_name')
					->from('contract c')
					->join('state s', 's.id=c.state','left')
					->join('ga g', 'g.id=c.ga','left')
					->join('supplier sp', 'sp.id=c.supplier','left')
					->where('c.id', $id)->get()->row_array();
	}

	/**
	 * To get Contract Export
	 */ 
	public function getContractExport($params)
	{
		$this->db->select("c.code,c.name,ct.name as contract_type,sp.name as supplier,c.mgo,c.dcq,IF(c.price_unit = 1, 'SCM', IF(c.price_unit = 2, 'MMBTU', '--')),s.name as state,g.name as ga,DATE_FORMAT(c.start_date,'%d-%m-%Y'),DATE_FORMAT(c.end_date,'%d-%m-%Y'),c.excess_limit,c.overdraw_price,c.underdraw_price,c.transport_price,CONCAT_WS(' ','Priority',c.priority),IF(c.status = 1, 'Active', IF(c.status = 0, 'InActive','--'))");
		$this->getContractQry($params);
		$this->db->order_by('c.added_at', 'DESC');
		return $this->db->get()->result_array();
	}

	/**
	 * To get the Priorites List Num
	 */ 
	public function getContractPriorityNum($params)
	{
		return $this->db->select('count(id) as tRecords')->get_where('contract', array('state' => $params['state'], 'ga' => $params['ga'], 'supplier' => $params['supplier']))->row_array();
	}

	/**
	 * To Count the Number of Priorities
	 */ 
	public function getMaxPriority()
	{
		return $this->db->select('max(priority) as tRecords')->from('contract')->get()->row_array()['tRecords'];
	}
}