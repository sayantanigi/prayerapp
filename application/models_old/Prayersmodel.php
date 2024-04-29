<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Prayersmodel extends CI_Model {
    //set column field database for datatable orderable
	var $column_order = array('all_prayers.id','all_prayers.prayer_name','all_prayers.prayer_subheading','all_prayers.prayer_subheading','all_prayers.prayer_datetime','all_prayers.created_date',); 
    var $order = array('all_prayers.id' => 'DESC'); 

    function __construct() {
        parent::__construct();
    }
	
	private function _get_datatables_query($cond) {
        $this->db->select('all_prayers.*');
        $this->db->from('all_prayers');
        $this->db->where($cond);
		$i = 0;
        $new_str = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['search']['value']);
        if($new_str) {
            $explode_string = explode(' ', $new_str);
            //print_r($explode_string); die();
            foreach ($explode_string as $show_string) {  
                $cond  = " ";
                $cond.=" ( all_prayers.prayer_datetime = '".$show_string."' ";
                $cond.=" OR all_prayers.prayer_name LIKE '%".$show_string."%'";
                $cond.=" OR all_prayers.prayer_subheading LIKE '%".$show_string."%'";
                $cond.=" OR all_prayers.prayer_datetime LIKE '%".$show_string."%'";
                $cond.=" OR all_prayers.created_date LIKE '%".date('Y-m-d',strtotime($show_string))."%') ";
                $this->db->where($cond);
            }
        }
        $i++;
        
        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	function get_datatables($cond) {
        $this->_get_datatables_query($cond);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $this->db->where($cond);
        //echo $this->db->last_query();die;
        return $query->result();
    }

	public function count_all($cond) {    
        $this->_get_datatables_query($cond);
        return $this->db->count_all_results();
    }

	function count_filtered($cond) {
        $this->_get_datatables_query($cond);
        $query = $this->db->get();
        return $query->num_rows();
    }
}