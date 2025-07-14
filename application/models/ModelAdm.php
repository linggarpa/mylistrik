<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelAdm extends CI_Model
{
    /**
     * Ambil data user berdasarkan kondisi tertentu.
     *
     * @param array|null $where Array kondisi untuk filter data user.
     * @return CI_DB_result Query result object.
     */
   public function cekData($where = null)
    {
        return $this->db->get_where('user', $where);
    }

    /**
     * Hapus data pelanggan berdasarkan ID.
     *
     * @param int|string $id ID pelanggan yang akan dihapus.
     * @return void
     */
    public function hapus_pelanggan($id)
    {
        $this->db->where('id_pelanggan', $id);
        $this->db->delete('pelanggan');
    }

    /** 
     * Ambil data pelanggan berdasarkan kondisi tertentu.
     *
     * @param array $where Array kondisi untuk filter data pelanggan.
     * @return CI_DB_result Query result object.
     */
    public function plgWhere($where)
    {
        return $this->db->get_where('pelanggan', $where);
    }

    /**
     * Ambil data petugas/user berdasarkan kondisi tertentu.
     *
     * @param array $where Array kondisi untuk filter data user.
     * @return CI_DB_result Query result object.
     */
    public function petugasWhere($where)
    {
        return $this->db->get_where('user', $where);
    }

    /**
     * Update data pelanggan.
     *
     * @param array|null $data Array data yang akan diupdate.
     * @param array|null $where Array kondisi untuk memilih record yang akan diupdate.
     * @return void
     */
    public function updatePelanggan($data = null, $where = null)
    {
        $this->db->update('pelanggan', $data, $where);
    }

     /**
     * Simpan data ke tabel tertentu.
     *
     * @param string $table Nama tabel.
     * @param array $data Array data yang akan disimpan.
     * @return bool True jika berhasil, false jika gagal.
     */
    public function simpanData($table, $data)
    {
        return $this->db->insert($table, $data);
    }

  /**
     * Hapus data petugas/user berdasarkan ID.
     *
     * @param int|string $id ID user yang akan dihapus.
     * @return void
     */
    public function hapus_petugas($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
    }

    /**
     * Update data petugas/user.
     *
     * @param array|null $data Array data yang akan diupdate.
     * @param array|null $where Array kondisi untuk memilih record yang akan diupdate.
     * @return void
     */
    public function updatePetugas($data = null, $where = null)
    {
        $this->db->update('user', $data, $where);
    }
    /**
     * Update data tarif.
     *
     * @param array|null $data Array data yang akan diupdate.
     * @param array|null $where Array kondisi untuk memilih record yang akan diupdate.
     * @return void
     */
    public function updateTarif($data = null, $where = null)
    {
        $this->db->update('tarif', $data, $where);
    }

    /**
     * Hapus data tarif berdasarkan ID.
     *
     * @param int|string $id ID tarif yang akan dihapus.
     * @return void
     */
    public function hapus_tarif($id)
    {
        $this->db->where('id_tarif', $id);
        $this->db->delete('tarif');
    }

    /**
     * Hapus data penggunaan berdasarkan ID.
     *
     * @param int|string $id ID penggunaan yang akan dihapus.
     * @return void
     */
    public function hapus_penggunaan($id)
    {
        $this->db->where('id_penggunaan', $id);
        $this->db->delete('penggunaan');
    }

    /**
     * Hapus data tagihan berdasarkan ID.
     *
     * @param int|string $id ID tagihan yang akan dihapus.
     * @return void
     */
    public function hapus_tagihan($id)
    {
        $this->db->where('id_tagihan', $id);
        $this->db->delete('tagihan');
    }
    
    /**
     * Ambil semua data pelanggan.
     *
     * @return array Array data pelanggan.
     */
    public function get_all_pelanggan()
    {
        return $this->db->get('pelanggan')->result_array();
    }

     public function get_user_by_id($id)
    {
        return $this->db->get_where('user', ['id_user' => $id])->row_array();
    }

}