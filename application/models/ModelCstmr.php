<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelCstmr extends CI_Model
{

    public function cekData($where = null)
    {
        return $this->db->get_where('pelanggan', $where);
    }

    public function get_all_tarif()
    {
        return $this->db->get('tarif')->result_array();
    }

     // Ambil tagihan belum dibayar berdasarkan id_pelanggan
    public function get_unpaid_by_pelanggan($id_pelanggan)
    {
         return $this->db->get_where('tagihan', [
            'id_pelanggan' => $id_pelanggan,
            'status' => 'UNPAID'
        ])->result_array();
    }

    public function viewtagihan($where)
    {
        return $this->db->get_where('view_total_bayar', $where)->result_array();
    }


    public function simpanData($data = null)
    {
        $this->db->insert('pelanggan', $data);
    }

    public function simpanDataPembayaran($data = null)
    {
        $this->db->insert('pembayaran', $data);
    }

}
