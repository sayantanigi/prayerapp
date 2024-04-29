<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Productmodel extends My_Model {
var $column_order = array('product_list.id','product_list.pro_cat_id','product_list.pro_name','product_list.pro_desc','product_list.mrp','product_list.discount','product_list.final_price'); //set column field database for datatable orderable

    var $order = array('product_list.id' => 'DESC');

    function __construct() {
        parent::__construct();
    }

	private function _get_datatables_query($cond) {
		$this->db->select('product_list.*');
        $this->db->from('product_list');
        $this->db->where($cond);
		$i = 0;
        $new_str = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['search']['value']);
        if($new_str) {
            $explode_string = explode(' ', $new_str);
            foreach ($explode_string as $show_string) {
                // echo $show_string;
                $cond  = " ";
                $cond.=" (  product_list.pro_name LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  product_list.status LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  product_list.created_date LIKE '%".trim(date('Y-m-d',strtotime($show_string)))."%') ";
                $this->db->where($cond);
                //echo $this->db->last_query();die;
            }
            /*die;
            $explode_string = explode('-', $_POST['search']['value']);
            foreach ($explode_string as $show_string) {
                echo $show_string;
            }
            die;*/
        }
        $i++;

        if(isset($_POST['order'])) {
            //print_r($this->column_order);exit;
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
