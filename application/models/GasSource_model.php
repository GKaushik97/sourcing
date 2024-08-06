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
        $qry = $this->db->select('gs.nomination_unit, sum(gs.nomination_qty) as total')
        ->from('gas_sourcing gs')
        ->join('contract c','gs.contract = c.id','left')
        ->where('gs.state',$params['state'])
        ->where('gs.ga',$params['ga'])
        ->where('c.supplier',$params['supplier'])
        ->where('gs.source_date',$date)
        ->group_by('gs.nomination_unit')
        ->get();
        return $qry->result_array(); 
    }
    /*
    * Get Nominated contracts
    */
    public function getNominatedContracts($params)
    {
        $date = date('Y-m-d',strtotime($params['selected_date']));
        return $this->db->select('c.id, c.code, c.name, c.mgo, c.dcq, ct.name as type_name, c.price_unit, gs.id as nomination_id, gs.nomination_qty, gs.nomination_unit, gs.allocation_qty, gs.allocation_unit')
        ->from('gas_sourcing gs')
        ->join('contract c','gs.contract = c.id','left')
        ->join('contract_type ct', 'ct.id = c.type', 'left')
        ->where('gs.state',$params['state'])
        ->where('gs.ga',$params['ga'])
        ->where('c.supplier',$params['supplier'])
        ->where('gs.source_date',$date)
        ->order_by('c.priority','asc')
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
            ->where('supplier',$params['supplier'])
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
        return $this->db->select('c.id, c.name, g.source_date, g.nomination_qty, g.nomination_unit, g.allocation_qty, g.allocation_unit, g.gcv')
            ->from('gas_sourcing g')
            ->join('contract c', 'g.contract = c.id','left')
            ->where('g.state', $params['state'])
            ->where('g.ga', $params['ga'])
            ->where('c.supplier',$params['supplier'])
            ->order_by('g.source_date','desc')
            ->order_by('c.priority','asc')
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
    /*
    * Get Gas source reports data
    */
    public function getGasSourceReportsData($params)
    {
        return $this->db->select('c.id, c.code, c.name, gs.source_date, gs.nomination_qty, gs.nomination_unit, gs.allocation_qty, gs.allocation_unit, gs.gcv')
        ->from('gas_sourcing gs')
        ->join('contract c', 'gs.contract = c.id','left')
        ->where('gs.state', $params['state'])
        ->where('gs.ga', $params['ga'])
        ->where('c.supplier', $params['supplier'])
        ->where('DATE_FORMAT(gs.source_date,"%Y-%m-%d") >= ', date('Y-m-d',strtotime($params['date1'])))
        ->where('DATE_FORMAT(gs.source_date,"%Y-%m-%d") <= ', date('Y-m-d',strtotime($params['date2'])))
        ->get()->result_array();
    }
    /*
    * Get Gas source consumption data
    */
    public function getGasSourceConsumptionData($params)
    {
        return $this->db->select('consumption_date, quantity, gcv')
        ->from('gas_consumption')
        ->where('state',$params['state'])
        ->where('ga',$params['ga'])
        ->where('supplier',$params['supplier'])
        ->get()->result_array();
    }
    /**
     * To get All the Suppliers
     */ 
    public function getSuppliers()
    {
        $qry = $this->db->select('*')->from('supplier')->get();
        if($qry->num_rows() > 0){
            foreach ($qry->result_array() as $key => $value) {
                $data[$value['id']] = $value;
            }
            return $data;
        }
        return false;
    }
    /**
     * To get All the State
     */ 
    public function getStates()
    {
        $qry = $this->db->select('*')->from('state')->get();
        if($qry->num_rows() > 0){
            foreach ($qry->result_array() as $key => $value) {
                $data[$value['id']] = $value;
            }
            return $data;
        }
        return false;
    }
    /**
     * To get All the Gas
     */ 
    public function getGas()
    {
        $qry = $this->db->select('*')->from('ga')->get();
        if($qry->num_rows() > 0){
            foreach ($qry->result_array() as $key => $value) {
                $data[$value['id']] = $value;
            }
            return $data;
        }
        return false;
    }
    /*
    * Get Nomination Data
    */
    public function getNominationData($params, $contract)
    {
        $date = date('Y-m-d',strtotime($params['selected_date']));
        return $this->db->select('gs.nomination_qty, gs.nomination_unit')
        ->from('gas_sourcing gs')
        ->where('gs.state',$params['state'])
        ->where('gs.ga',$params['ga'])
        ->where('gs.contract',$contract)
        ->where('gs.source_date',$date)
        ->get()->row_array();
    }

    /**
     * Get GA Consumption Total
     */ 
    public function getGaConsumptionTotal($params)
    {
        $this->db->select('SUM(quantity) as total_qty')->from('gas_consumption');
        $this->db->where('state',$params['state']);
        $this->db->where('ga',$params['ga']);
        $this->db->where('supplier',$params['supplier']);
        $qry = $this->db->get();
        return $qry->row_array()['total_qty'];
    }

    /**
     * Get GA Consumption Total
     */ 
    public function getGaAllocationTotal($params)
    {
        $this->db->select('SUM(allocation_qty) as alloc_qty,SUM(nomination_qty) as nom_qty, contract,nomination_unit')->from('gas_sourcing');
        $this->db->where('state',$params['state']);
        $this->db->where('ga',$params['ga']);
        $this->db->where('DATE(source_date) >=',$params['from_date']);
        $this->db->where('DATE(source_date) <=',date('Y-m-d',strtotime($params['nomination_date'])));
        $this->db->group_by('contract,nomination_unit');
        $qry = $this->db->get();
        if($qry->num_rows() > 0) {
            foreach($qry->result_array() as $key => $value) {
                $contracts[$value['contract']][$value['nomination_unit']] = $value;
            }
            return $contracts;
        }
        return array();
    }
}
?>