<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcoupon extends CI_Model {

	public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->dbprefix('discount');
    }
    
    //Thêm
    public function coupon_insert($mydata)
    {
        $this->db->insert($this->table,$mydata);
    }
    public function coupon_customer(){
        $this->db->where('trash', 1);
        $this->db->where('status', 1);
        $this->db->where("expiration_date >= " , date('Y-m-d'));
        $this->db->where('orders', 1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
}