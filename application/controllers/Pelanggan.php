<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Admin (Adm)
 *
 * Mengelola halaman login dan register Mylistrik.
 *
 * @package     Application\Controllers
 * @subpackage  Auth
 * @category    Controller
 * @author      Linggar Pramudia Adi
 * @version     1.0
 */
class Pelanggan extends CI_Controller
{

     /**
     * Halaman utama pelanggan, menampilkan daftar tagihan.
     *
     * @return void
     */
    public function index(){
        $data['title'] = 'Home | Mylistrik';
        $id_pelanggan = $this->session->userdata('id_pelanggan');
        $queryTagihan = "SELECT * FROM view_total_bayar where id_pelanggan = '$id_pelanggan'";
        $Tagihan = $this->db->query($queryTagihan)->result_array();

        $countTagihan = $this->db->query($queryTagihan)->num_rows();

        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $data['Tagihan'] = $Tagihan;
        $data['countTagihan'] = $countTagihan;
        $data['nama_bulan'] = $nama_bulan;

        if ($this->session->userdata('username')) {
            $data['pelanggan'] = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('pelanggan/index', $data);
            $this->load->view('templates/user_footer');
        }else{
            redirect('auth');
        }
    }

    /**
     * Menampilkan riwayat pembayaran pelanggan.
     *
     * @return void
     */
    public function RiwayatBayar(){
        $data['title'] = 'Riwayat Bayar | Mylistrik';
        $id_pelanggan = $this->session->userdata('id_pelanggan');
        $status = 'PAID';
        $queryRbayar = "SELECT * FROM pembayaran JOIN tagihan ON pembayaran.id_tagihan = tagihan.id_tagihan where  tagihan.status = 'PAID' AND pembayaran.id_pelanggan = '$id_pelanggan' ";
        $Rbayar = $this->db->query($queryRbayar)->result_array();

        $countRbayar = $this->db->query($queryRbayar)->num_rows();

        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $data['Rbayar'] = $Rbayar;
        $data['countRbayar'] = $countRbayar;
        $data['nama_bulan'] = $nama_bulan;
      
        if ($this->session->userdata('username')) {
            $data['pelanggan'] = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('pelanggan/riwayat_bayar.php', $data);
            $this->load->view('templates/user_footer');
        }else{
            redirect('auth');
        }
    }

     /**
     * Menampilkan halaman untuk membayar tagihan tertentu.
     *
     * @return void
     */
    public function bayar()
    {
        $data['title'] = 'Bayar| Mylistrik';
        if ($this->session->userdata('username')) {
            $data['pelanggan'] = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();
            $data['bayar'] = $this->ModelCstmr->viewtagihan(['id_tagihan' => $this->uri->segment(3)]);
            $nama_bulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
           
            $data['nama_bulan'] = $nama_bulan;
      
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('pelanggan/bayar', $data);
            $this->load->view('templates/user_footer');
        }else{
            redirect('auth');
        }
    }

    /**
     * Menampilkan halaman detail pembayaran.
     *
     * @return void
     */
    public function halamanBayar(){
        $data['title'] = 'Pembayaran| Mylistrik';
        if ($this->session->userdata('username')) {
            $data['pelanggan'] = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();
            $data['pembayaran'] = $this->ModelCstmr->viewtagihan(['id_tagihan' => $this->uri->segment(3)]);
            $nama_bulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
            $queryIDPembayaran = "SELECT max(id_pembayaran) as maxID FROM pembayaran";
            $data['idP'] = $this->db->query($queryIDPembayaran)->result_array();
            $data['nama_bulan'] = $nama_bulan;

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('pelanggan/pembayaran', $data);
            $this->load->view('templates/user_footer');

        }else{
            redirect('auth');
        }
    }

    /**
     * Proses pembayaran tagihan.
     * Validasi nominal pembayaran harus sama dengan total tagihan.
     * Jika valid, simpan data pembayaran dan update status tagihan menjadi PROCESS.
     *
     * @return void
     */
    public function GoBayar(){
        function bersihkanRupiah($string)
        {
                    $string = str_replace('Rp', '', $string);
                    $string = str_replace('.', '', $string);
                    return $string;
        }
        $dana = $this->input->post('nominal_bayar');
        $total = $this->input->post('totalbyr');
        $id_tagihan = $this->input->post('id_tagihan');
        $dana_rupiah = bersihkanRupiah($dana);

        if ((int)$dana_rupiah !== (int)$total) {
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-danger alert-message" role="alert">
                Nominal pembayaran tidak sesuai dengan total tagihan. Silakan coba lagi.
            </div>'
        );
        redirect('pelanggan/pembayaran/' . $id_tagihan);
        return; // hentikan eksekusi
        }

        $data = [
                'id_pembayaran' => $this->input->post('id_pembayaran'),
                'id_tagihan' => $this->input->post('id_tagihan'),
                'id_pelanggan' => $this->input->post('id_pelanggan'),
                'tanggal_pembayaran' => $this->input->post('tgl_bayar'),
                'bulan_bayar' => $this->input->post('bulan'),
                'biaya_admin' => 2500,
                'total_bayar' => $this->input->post('totalbyr'),
                'id_user' => 'USR000'
        ];
            // Simpan data pembayaran
            $this->ModelCstmr->simpanDataPembayaran($data);

            // Ubah status tagihan jadi 'PROCESS'
            $id_tagihan = $this->input->post('id_tagihan');
            $this->db->where('id_tagihan', $id_tagihan);
            $this->db->update('tagihan', ['status' => 'PROCESS']);

            // Notifikasi + redirect
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Pembayaran berhasil diproses!</div>
                <meta http-equiv="refresh" content="2">'
            );

            redirect('pelanggan');
    }

    
}