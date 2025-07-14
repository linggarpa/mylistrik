<?php
class UnitTest extends CI_Controller {

    public function index()
    {
        echo "<h2>Unit Testing Penambahan Tarif</h2>";
        $this->test_tambah_tarif();
    }

    public function test_tambah_tarif()
    {
    // Step 1: Data tarif dummy
    $id_tarif = 'T999'; // Gunakan ID unik agar tidak bentrok
    $data_tarif = [
        'id_tarif' => $id_tarif,
        'daya' => '2200VA',
        'tarifperkwh' => 1450
    ];

    // Step 2: Simpan ke database
    $this->load->model('ModelAdm');
    $this->ModelAdm->simpanData('tarif', $data_tarif);

    // Step 3: Ambil kembali dari DB
    $saved = $this->db->get_where('tarif', ['id_tarif' => $id_tarif])->row_array();

    // Step 4: Uji apakah data berhasil disimpan
    echo $this->unit->run($saved['daya'], '2200VA', 'Cek daya yang disimpan');
    echo $this->unit->run($saved['tarifperkwh'], 1450, 'Cek tarif per kWh yang disimpan');

    // Step 5: Cleanup (hapus data setelah test)
    $this->db->delete('tarif', ['id_tarif' => $id_tarif]);
    }
}
