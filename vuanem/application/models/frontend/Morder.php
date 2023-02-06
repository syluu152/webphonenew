<?php
class Morder extends CI_Model {
        public function __construct()
        {
                parent::__construct();
                $this->table = $this->db->dbprefix('order');
        }
        // get 1 đơn hàng mới nhất theo id khách hàng
        public function order_detail_customerid($customerid)
        {
                $this->db->where('customerid', $customerid);
                $this->db->order_by('id' , 'desc');
                $this->db->limit(1);
                $query = $this->db->get($this->table);
                return $query->row_array();
        }
        // get order mới nhất theo mã code
        public function order_detail_by_code($code)
        {
            $this->db->where('orderCode', $code);
            $this->db->limit(1);
            $query = $this->db->get($this->table);
            return $query->row_array();
        }
        // thêm đơn hàng
        public function order_insert($mydata)
        {
                $this->db->insert($this->table,$mydata);
        } 
        // get đơn hàng theo id order
        public function order_detail($id)
        {
                $this->db->where('id',$id);
                $this->db->where('trash', 1);
                $query = $this->db->get($this->table);
                return $query->row_array();
        }
        // cập nhật đơn hàng theo id
        public function order_update($mydata, $id)
        {
                $this->db->where('id',$id);
                $this->db->update($this->table, $mydata);
        }
        // xóa đơn hàng theo id
        public function orders_delete($orderCode)
        {
            $this->db->where('orderCode',$orderCode);
            $this->db->delete($this->table);
        }
}