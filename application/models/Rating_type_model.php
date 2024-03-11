<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rating_type_model extends My_Model {
var $column_order = array(null,null,'rating_type.rating_type','rating_type.status',null); //set column field database for datatable orderable
 
    var $order = array('rating_type.id' => 'DESC'); 

    function __construct()
    {
        parent::__construct();
    }
	
	private function _get_datatables_query()
	{
		$this->db->select('rating_type.*');
        $this->db->from('rating_type');
      // $this->db->where($cond);
		$i = 0;
     
        if($_POST['search']['value']) // if datatable send POST for search
            {
                $explode_string = explode(' ', $_POST['search']['value']);
                foreach ($explode_string as $show_string) 
                {  
                    $cond  = " ";
                    $cond.=" (  rating_type.rating_type LIKE '%".trim($show_string)."%' ";
                    $cond.=" OR  rating_type.status LIKE '%".trim($show_string)."%') ";
                    $this->db->where($cond);
                }
            }
        $i++;
        
        if(isset($_POST['order'])) // here order processing
        {
            //print_r($this->column_order);exit;
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
       // $this->db->where();
        return $query->result();
    }

	 public function count_all()
    {    
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }


	function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
}