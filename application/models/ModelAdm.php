<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelAdm extends CI_Model
{
   public function cekData($where = null)
    {
        return $this->db->get_where('user', $where);
    }

    public function hapus_pelanggan($id)
    {
        $this->db->where('id_pelanggan', $id);
        $this->db->delete('pelanggan');
    }

    public function plgWhere($where)
    {
        return $this->db->get_where('pelanggan', $where);
    }
    public function petugasWhere($where)
    {
        return $this->db->get_where('user', $where);
    }

    public function updatePelanggan($data = null, $where = null)
    {
        $this->db->update('pelanggan', $data, $where);
    }

    public function simpanData($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function hapus_petugas($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
    }

    public function updatePetugas($data = null, $where = null)
    {
        $this->db->update('user', $data, $where);
    }
    public function updateTarif($data = null, $where = null)
    {
        $this->db->update('tarif', $data, $where);
    }

    public function hapus_tarif($id)
    {
        $this->db->where('id_tarif', $id);
        $this->db->delete('tarif');
    }

    public function hapus_penggunaan($id)
    {
        $this->db->where('id_penggunaan', $id);
        $this->db->delete('penggunaan');
    }

    public function hapus_tagihan($id)
    {
        $this->db->where('id_tagihan', $id);
        $this->db->delete('tagihan');
    }
    public function get_all_pelanggan()
    {
        return $this->db->get('pelanggan')->result_array();
    }

}