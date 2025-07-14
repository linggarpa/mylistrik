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

    /**
     * Menampilkan data profil pelanggan beserta data tarif terkait.
     *
     * Fungsi ini mengambil data dari tabel `pelanggan` dan melakukan join 
     * dengan tabel `tarif` berdasarkan `id_tarif`. Parameter `$where` digunakan 
     * untuk menyaring hasil query sesuai dengan kondisi yang diberikan.
     *
     * @param array $where Kondisi WHERE untuk query (misalnya: ['id_pelanggan' => 1]).
     * @return array Hasil query dalam bentuk array asosiatif.
     */
    public function viewprofile($where)
    {
        $this->db->select('pelanggan.*, tarif.*');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif');
        $this->db->where($where);
        return $this->db->get()->result_array();
    }
    /**
     * Memperbarui data pelanggan di tabel `pelanggan`.
     *
     * Fungsi ini melakukan update data berdasarkan kondisi `$where` yang diberikan.
     * Data yang diupdate diberikan melalui parameter `$data`.
     *
     * @param array|null $data Data yang akan diperbarui (misalnya: ['nama' => 'Ahmad']).
     * @param array|null $where Kondisi WHERE untuk menentukan baris yang akan diupdate 
     *                          (misalnya: ['id_pelanggan' => 1]).
     * @return void
     */
    public function updatePelanggan($data = null, $where = null)
    {
        $this->db->update('pelanggan', $data, $where);
    }


}
