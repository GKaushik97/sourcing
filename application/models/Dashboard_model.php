<?php
/**
 * Dashboard Model
 */ 

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /*
    *Get Geo Areas
    */
    public function getGeoAreas()
    {
        return $this->db->select('g.id, s.name as state, g.name, g.code')
        ->from('ga g')
        ->join('state s','s.id = g.state','left')
        ->get()->result_array();
    }
    /*
    * Get Nomination n allocation Counts
    */
    public function getNominationCounts($params)
    {
        return $this->db->select('ga, SUM(IF(nomination_unit = 1, nomination_qty*(gcv/252000), IF(nomination_unit = 2, nomination_qty, "0"))) as nomination_mmbtu, SUM(IF(allocation_unit = 1, allocation_qty*(gcv/252000), IF(allocation_unit = 2, allocation_qty, "0"))) as allocation_mmbtu')
            ->from('gas_sourcing')
            ->where('DATE_FORMAT(source_date,"%Y-%m-%d") >= ', date('Y-m-d',strtotime($params['date1'])))
            ->where('DATE_FORMAT(source_date,"%Y-%m-%d") <= ', date('Y-m-d',strtotime($params['date2'])))
            ->group_by('ga')
            ->get()->result_array();
    }
    public function getDcqContractsCounts()
    {
        return $this->db->select('ga, SUM(IF(price_unit = 1, dcq*(9294.11/252000), IF(price_unit = 2, dcq, "0"))) as dcq_mmbtu')
            ->from('contract')
            ->where('status',1)
            ->group_by('ga')
            ->get()->result_array();   
    }

    /**
     * Total number of Active Contracts 
     */ 
    public function getNumberOfContracts()
    {
        return $this->db->select('count(id) as tRecords')->get_where('contract', ['status' => 1])->row_array()['tRecords'];
    }

    /**
     * Total Sum of Dcq Value 
     */ 
    public function getSumOfDcqValue()
    {
        return $this->db->select('SUM(IF(price_unit = 1, dcq*(9294.11/252000), IF(price_unit = 2, dcq, "0"))) as dcq_mmbtu')->get_where('contract', ['status' => 1])->row_array()['dcq_mmbtu'];
    }

    /**
     * Total Geo Areas
     */ 
    public function getTotalGa()
    {
        return $this->db->select('count(id) as trecords')->get('ga')->row_array()['trecords'];
    }
}