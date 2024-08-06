<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Supplier Model
 */
class Supplier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * To get All the Suppliers
     */ 
    public function getAllSuppliers()
    {
        return $this->db->select('*')->from('supplier')->get()->result_array();
    }

    /**
     * To Insert the Supplier
     */ 
    public function insertSupplier($data) 
    {
        return $this->db->insert('supplier', $data);
    }

    /**
     * Get the Supplier By using Id
     */ 
    public function getSupplierById($id) 
    {
        return $this->db->select('*')->from('supplier')->where('id', $id)->get()->row_array();
    }
    /**
     * To Update the Supplier
     */ 
    public function updateSupplier($data,$id) 
    {
        return $this->db->where('id',$id)->update('supplier', $data);
    }
}