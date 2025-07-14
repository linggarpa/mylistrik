<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelCstmr extends CI_Model
{
    /**
     * Ambil data pelanggan berdasarkan kondisi tertentu.
     *
     * @param array|null $where Array kondisi untuk filter data pelanggan.
     * @return CI_DB_result Query result object.
     */

    public function cekData($where = null)
    {
        return $this->db->get_where('pelanggan', $where);
    }

    /**
     * Ambil semua data tarif.
     *
     * @return array Array data tarif.
     */
    public function get_all_tarif()
    {
        return $this->db->get('tarif')->result_array();
    }

    /**
     * Ambil data tagihan yang belum dibayar berdasarkan ID pelanggan.
     *
     * @param int|string $id_pelanggan ID pelanggan.
     * @return array Array data tagihan belum dibayar.
     */
     // Ambil tagihan belum dibayar berdasarkan id_pelanggan
    public function get_unpaid_by_pelanggan($id_pelanggan)
    {
         return $this->db->get_where('tagihan', [
            'id_pelanggan' => $id_pelanggan,
            'status' => 'UNPAID'
        ])->result_array();
    }

    /**
     * Ambil data tagihan dengan kondisi tertentu dari view_total_bayar.
     *
     * @param array $where Array kondisi filter.
     * @return array Array data hasil query.
     */
    public function viewtagihan($where)
    {
        return $this->db->get_where('view_total_bayar', $where)->result_array();
    }

    /**
     * Simpan data pelanggan baru.
     *
     * @param array|null $data Array data pelanggan yang akan disimpan.
     * @return void
     */

    public function simpanData($data = null)
    {
        $this->db->insert('pelanggan', $data);
    }
    
    /**
     * Simpan data pelanggan baru.
     *
     * @param array|null $data Array data pelanggan yang akan disimpan.
     * @return void
     */

    public function simpanDataPembayaran($data = null)
    {
        $this->db->insert('pembayaran', $data);
    }

}
