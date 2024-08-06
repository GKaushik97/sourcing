<?php
/**
 * Gas Source Model
 */ 

class GasSource_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List of Gas Source Contract
     * state, ga, nomination_date
     */ 
    public function getGaContracts($params)
    {
        $this->db->select('c.*, s.name as supplier_name, ct.name as type_name')
            ->from('contract c')
            ->join('supplier s', 's.id = c.supplier', 'LEFT')
            ->join('contract_type ct', 'ct.id = c.type', 'LEFT');
        $this->db->where('c.state', $params['state'])->where('c.ga', $params['ga'])->where('c.status', '1')->where('c.supplier', $params['supplier']);
        $qry = $this->db->get();
        return $qry->result_array();
    }

    //To Insert the NominationQuantity using insert_batch method 
    public function nomination_insert($data)
    {
        return $this->db->insert_batch('gas_sourcing', $data);
    }
    
    //To Update the NominationQuantity using update_batch method
    public function nomination_update($nomination_update) 
    {
        return $this->db->update_batch('gas_sourcing', $nomination_update, 'id');
    }

    /**
    * List of Gas Source Contract
    */ 
    public function getGaNomination($params)
    {
        $this->db->select('*')->from('gas_sourcing');
        $this->db->where('state', $params['state'])->where('ga', $params['ga'])->where('source_date', date('Y-m-d', strtotime($params['nomination_date'])));
        $qry = $this->db->get();
        if($qry->num_rows() > 0) {
            foreach($qry->result_array() as $values) {
                $nominations[$values['contract']] = $values;
            }
            return $nominations;
        } else {
            return array();
        }
    }
    /**
     * Get Gas_Sourcing History
     */ 
    public function getGaContractNominationHistory($params) {
        $this->db->select('g.*,c.code,c.name,c.supplier,c.type,s.name as supplier_name, ct.name as contract_type')
                 ->from('gas_sourcing g')
                 ->join('contract c', 'c.id=g.contract','left')
                 ->join('supplier s','s.id=c.supplier','left')
                 ->join('contract_type ct', 'ct.id=c.type','left');
        $this->db->where('g.state', $params['state'])->where('g.ga', $params['ga']);
        $this->db->order_by('g.source_date', 'DESC');
        $this->db->limit(15,0);
        return $this->db->get()->result_array();
    }
    /*
    * Get Nominated Total Value @Raji
    */
    public function getTotalNominatedValue($params)
    {
       $date = date('Y-m-d',strtotime($params['selected_date']));
        $qry = $this->db->select('sum(gs.nomination_qty) as total')
        ->from('gas_sourcing gs')
        ->join('contract c','gs.contract = c.id','left')
        ->where('gs.state',$params['state'])
        ->where('gs.ga',$params['ga'])
        ->where('c.supplier',$params['supplier'])
        ->where('gs.source_date',$date)
        ->get();
        return $qry->row_array()['total']; 
    }
    /*
    * Get Nominated contracts
    */
    public function getNominatedContracts($params)
    {
        $date = date('Y-m-d',strtotime($params['selected_date']));
        return $this->db->select('c.id, c.code, c.name, c.mgo, c.dcq, ct.name as type_name, gs.nomination_qty,gs.nomination_unit, gs.allocation_qty, gs.allocation_unit')
        ->from('gas_sourcing gs')
        ->join('contract c','gs.contract = c.id','left')
        ->join('contract_type ct', 'ct.id = c.type', 'left')
        ->where('gs.state',$params['state'])
        ->where('gs.ga',$params['ga'])
        ->where('c.supplier',$params['supplier'])
        ->where('gs.source_date',$date)
        ->get()->result_array();
    }
    /*
    * Update Nomination Details
    */
    public function updateNomination($data,$params,$con_id){
        $sdate = date('Y-m-d',strtotime($params['selected_date']));
        return $this->db->set($data)->where('state',$params['state'])->where('ga',$params['ga'])->where('contract',$con_id)->where('source_date',$sdate)->update('gas_sourcing');
    }
    /*
    * Insert Consumption
    */
    public function insertConsumption($data)
    {
        return $this->db->insert('gas_consumption', $data);
    }
    /*
    *Get Consumption Details
    */
    public function getConsumptionDetails($params){
        $sdate = date('Y-m-d',strtotime($params['selected_date']));
        return $this->db->select('*')
            ->from('gas_consumption')
            ->where('state',$params['state'])
            ->where('ga',$params['ga'])
            ->where('consumption_date',$sdate)
            ->get()->row_array();
    }
    /*
    * Update Nomination Details
    */
    public function updateConsumption($data,$params){
        $sdate = date('Y-m-d',strtotime($params['selected_date']));
        return $this->db->set($data)->where('state',$params['state'])->where('ga',$params['ga'])->where('consumption_date',$sdate)->update('gas_consumption');
    }
    /**
     * Get Allocation History
     */ 
    public function getAllocationHistory($params) {
        return $this->db->select('c.id, c.name, g.source_date, g.nomination_qty, g.nomination_unit, g.allocation_qty, g.allocation_unit')
            ->from('gas_sourcing g')
            ->join('contract c', 'c.id=g.contract','left')
            ->where('g.state', $params['state'])
            ->where('g.ga', $params['ga'])
            ->where('c.supplier',$params['supplier'])
            ->order_by('g.source_date','desc')
            ->limit(15,0)
            ->get()->result_array();
    }

    /**
     * GA Nomination  By Using Id
     */ 
    public function getGaNominationById($id)
    {
         $qry = $this->db->select('contract,nomination_qty,nomination_unit')->from('gas_sourcing')->where_in('id', $id)->get();
         if($qry->num_rows() > 0) {
            foreach($qry->result_array() as $values) {
                $geo_nomination[$values['contract']] = $values;
            }
            return $geo_nomination;
        } else {
            return array();
        }
        
    }
}
?>