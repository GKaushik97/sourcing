<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contract_Types 
 */
class ContractTypes_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * To get the Total-Contract-Types
	 */ 
	public function getAllContractTypesNum()
	{
		$this->db->select('id');
		$this->db->from('contract_type');
		return $this->db->count_all_results();
	}

	/**
	 * Get Contract_types
	 */
	public function getAllContractTypes()
	{
		return $this->db->get('contract_type')->result_array();
	}

	/**
	 * Add ContractType
	 */ 
	public function insertContractType($data)
	{
		return $this->db->insert('contract_type', $data);
	}

	/**
	 * Get the Contract By Id
	 */
	public function getContractTypeById($id)
	{
		return $this->db->select('*')->where('id', $id)->get('contract_type')->row_array();
	}  

	/**
	 * Update ContractType
	 */ 
	public function updateContractType($data, $id)
	{
		return $this->db->where('id', $id)->update('contract_type', $data);
	}

	/**
	 * To Delete Contract Type
	 */ 
	public function deleteContractType($id)
	{
		return $this->db->where('id', $id)->delete('contract_type');
	}
}