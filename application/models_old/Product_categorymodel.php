<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_categorymodel extends My_Model {
    var $column_order = array('product_category.id','product_category.category_name','product_category.created_date'); //set column field database for datatable orderable
    
    var $order = array('product_category.id' => 'DESC');

    function __construct() {
        parent::__construct();
    }
    
    private function _get_datatables_query($cond) {
		$this->db->select('product_category.*');
        $this->db->from('product_category');
        $this->db->where($cond);
		$i = 0;
        $new_str = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['search']['value']);
        if($new_str) {
            $explode_string = explode(' ', $new_str);
            foreach ($explode_string as $show_string) {
                // echo $show_string;
                $cond  = " ";
                $cond.=" (  product_category.category_name LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  product_category.status LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  product_category.created_date LIKE '%".trim(date('Y-m-d',strtotime($show_string)))."%') ";
                $this->db->where($cond);
                // echo $this->db->last_query();die;
            }
            /*$explode_string = explode('-', $_POST['search']['value']);
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
