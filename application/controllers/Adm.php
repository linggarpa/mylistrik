<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Admin (Adm)
 *
 * Mengelola halaman dashboard admin aplikasi Mylistrik.
 *
 * @package     Application\Controllers
 * @subpackage  Admin
 * @category    Controller
 * @author      Linggar Pramudia Adi
 * @version     1.0
 */
class Adm extends CI_Controller
{
    /**
     * Konstruktor kelas Adm
     *
     * Meload library form_validation dan memanggil konstruktor induk.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    /**
     * Menampilkan halaman utama dashboard Admin
     *
     * - Menyusun data total pelanggan, petugas, tagihan, penggunaan, dan pendapatan
     * - Memuat semua bagian layout: header, sidebar, topbar, halaman utama, dan footer
     *
     * @return void
     */
    public function index(){
        $data['title'] = 'Dashboard | Admin Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();

        $data['pelanggan'] = $this->db->get('pelanggan')->num_rows();
        $data['petugas'] = $this->db->get_where('user', ['id_level' => 'LVL002'])->num_rows();
        $data['totalTagihan'] = $this->db->get('tagihan')->num_rows();
        $data['totalPenggunaan'] = $this->db->get('penggunaan')->num_rows();
        $this->db->select_sum('total_bayar');
        $query = $this->db->get('pembayaran');
        $data['totalPendapatan'] = $query->row()->total_bayar;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

     /**
     * Menampilkan daftar pelanggan dengan pagination.
     *
     * - Menampilkan data pelanggan yang digabungkan dengan tarif
     * - Menyiapkan pagination secara manual
     * - Menyusun semua bagian layout tampilan
     *
     * @return void
     */
    public function pelanggan()
    {
        $data['title'] = 'Pelanggan | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
         // Pagination setup
        $limit = 5; // Number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Get the records for the current page
        $queryPelanggan = "SELECT * FROM pelanggan
                            JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif 
                            ORDER BY id_pelanggan desc 
                            LIMIT $limit OFFSET $offset;";
       $data['pelanggan']= $this->db->query($queryPelanggan)->result_array();

        // Count the total number of records to calculate the number of pages
        $totalRecords = $this->db->query("SELECT COUNT(*) as total FROM pelanggan")->row()->total;
        $data['totalPages'] = ceil($totalRecords / $limit);
        $data['page'] = $page;
        $data['offset'] = $offset;



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    
    /**
     * Menghapus pelanggan berdasarkan ID.
     *
     * @param string $id ID pelanggan yang akan dihapus
     * @return void
     */
    public function hapus_pelanggan($id)
    {

        $this->ModelAdm->hapus_pelanggan($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message" role="alert">Pelanggan berhasil dihapus</div>
                                    <meta http-equiv="refresh" content="2">'
        );
        redirect('adm/pelanggan');
    }

    /**
     * Menambahkan pelanggan baru ke sistem.
     *
     * - Melakukan validasi input
     * - Menampilkan form jika validasi gagal
     * - Menyimpan data jika validasi sukses
     *
     * @return void
     */
    public function tambah_pelanggan()
    {
        $data['title'] = 'Tambah Pelanggan | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $queryIDUser = "SELECT max(id_pelanggan) as maxID FROM pelanggan";
        $data['idP'] = $this->db->query($queryIDUser)->result_array();
       


        $this->form_validation->set_rules('username', 'username', 'required', [
            'required' => 'Username Belum diisi!!'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [ 
            'required' => 'Password Belum diisi!!',
            'min_length' => 'Password Terlalu Pendek'
        ]);


        $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required', [
            'required' => 'nomor kwh Belum diisi!!',
        ]);
        $this->form_validation->set_rules('nama_pelanggan', 'nama pelanggan', 'required', [
            'required' => 'nama Belum diisi!!',
        ]);
        $this->form_validation->set_rules('alamat', 'alamat', 'required', [
            'required' => 'alamat Belum diisi!!',
        ]);
        $this->form_validation->set_rules('tarif', 'tarif', 'required', [
            'required' => 'tarif Belum diisi!!',
        ]);

        if ($this->form_validation->run() == false) {
            $data['tarif'] = $this->ModelCstmr->get_all_tarif();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tambah-pelanggan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nomor_kwh' => htmlspecialchars($this->input->post('nomor_kwh', true)),
                'nama_pelanggan' => htmlspecialchars($this->input->post('nama_pelanggan', true)),
                'alamat' => $this->input->post('alamat', true),
                'id_tarif' => $this->input->post('tarif', true),
            ];

            $this->ModelAdm->simpanData('pelanggan',$data);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    pelanggan berhasil dibuat</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/pelanggan');
        }
    }
    /**
     * Menampilkan dan memproses form edit data pelanggan.
     *
     * - Mengambil data pelanggan berdasarkan ID dari URL segment.
     * - Menyediakan data tarif untuk dropdown.
     * - Melakukan validasi input form.
     * - Jika validasi sukses, update data pelanggan ke database.
     *
     * @return void
     */
    public function edit_pelanggan()
    {
        $data['title'] = 'Edit Pelanggan | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $data['tarif'] = $this->ModelCstmr->get_all_tarif();
        $id_pelanggan = $this->uri->segment(3);
        $queryPelanggan = "SELECT * FROM pelanggan JOIN tarif ON pelanggan.id_tarif = tarif.id_tarif WHERE pelanggan.id_pelanggan = '$id_pelanggan'";
        $data['pelanggan']= $this->db->query($queryPelanggan)->result_array();


        $this->form_validation->set_rules('username', 'username', 'required', [
            'required' => 'Username Belum diisi!!'
        ]);

        $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required', [
            'required' => 'nomor kwh Belum diisi!!',
        ]);
        $this->form_validation->set_rules('nama_pelanggan', 'nama', 'required', [
            'required' => 'nama Belum diisi!!',
        ]);
        $this->form_validation->set_rules('alamat', 'alamat', 'required', [
            'required' => 'alamat Belum diisi!!',
        ]);
        $this->form_validation->set_rules('tarif', 'tarif', 'required', [
            'required' => 'tarif Belum diisi!!',
        ]);

        if ($this->form_validation->run() == false) {
            $data['tarif'] = $this->ModelCstmr->get_all_tarif();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-pelanggan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'username' => htmlspecialchars($this->input->post('username', true)),        
                'nomor_kwh' => htmlspecialchars($this->input->post('nomor_kwh', true)),
                'nama_pelanggan' => htmlspecialchars($this->input->post('nama_pelanggan', true)),
                'alamat' => $this->input->post('alamat', true),
                'id_tarif' => $this->input->post('tarif', true),
            ];

            $this->ModelAdm->updatePelanggan($data, ['id_pelanggan' => $this->input->post('id_pelanggan')]);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    pelanggan berhasil diubah</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/pelanggan');
        }

        
    }

    /**
     * Menampilkan daftar petugas dengan pagination.
     *
     * - Mengambil data user yang merupakan petugas (id_level = 'LVL002')
     * - Menampilkan hasil dalam tampilan yang sudah dibagi halaman (paging)
     *
     * @return void
     */
    public function petugas(){
        $data['title'] = 'Petugas | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        
        // Pagination setup
        $limit = 5; // Number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Get the records for the current page
        $queryPetugas = "SELECT * FROM user where id_level = 'LVL002' ORDER BY id_user desc LIMIT $limit OFFSET $offset";
        $data['petugas']= $this->db->query($queryPetugas)->result_array();

        // Count the total number of records to calculate the number of pages
        $totalRecords = $this->db->query("SELECT COUNT(*) as total FROM user where id_level='LVL002'")->row()->total;
        $data['totalPages'] = ceil($totalRecords / $limit);
        $data['page'] = $page;
        $data['offset'] = $offset;



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_petugas', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menampilkan form tambah petugas dan memproses penyimpanan data petugas baru.
     *
     * - Validasi input form: username, password, nama admin.
     * - Jika validasi gagal, tampilkan kembali form tambah petugas.
     * - Jika validasi berhasil, data petugas disimpan ke tabel user dengan level 'LVL002'.
     *
     * @return void
     */
    public function tambah_petugas(){
        $data['title'] = 'Tambah Petugas | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $queryIDUser = "SELECT max(id_user) as maxID FROM user";
        $data['idU'] = $this->db->query($queryIDUser)->result_array();
       
        $this->form_validation->set_rules('username', 'username', 'required', [
            'required' => 'Username Belum diisi!!'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [ 
            'required' => 'Password Belum diisi!!',
            'min_length[3]' => 'Password Terlalu Pendek',
        ]);

        $this->form_validation->set_rules('nama_admin', 'nama admin', 'required', [
            'required' => 'nama Belum diisi!!',
        ]);

        if ($this->form_validation->run() == false) {
            $data['tarif'] = $this->ModelCstmr->get_all_tarif();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tambah-petugas', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_user' => $this->input->post('id_petugas', true),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama_admin' => htmlspecialchars($this->input->post('nama_admin', true)),
                'id_level' => 'LVL002'
            ];

            $this->ModelAdm->simpanData('user',$data);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    petugas berhasil dibuat</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/petugas');
        }

    }

    /**
     * Menghapus data petugas berdasarkan ID.
     *
     * - ID petugas diambil dari parameter.
     * - Memanggil model untuk menghapus petugas dari database.
     * - Menampilkan pesan berhasil menggunakan flashdata.
     *
     * @param string $id ID dari petugas yang akan dihapus
     * @return void
     */
    public function hapus_petugas($id)
    {

        $this->ModelAdm->hapus_petugas($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message" role="alert">petugas berhasil dihapus</div>
                                    <meta http-equiv="refresh" content="2">'
        );
        redirect('adm/petugas');
    }

    /**
     * Menampilkan form edit petugas dan memproses update data petugas.
     *
     * - Mengambil data petugas berdasarkan ID dari URL segment ke-3.
     * - Validasi input: username dan nama admin.
     * - Jika validasi gagal, tampilkan kembali form edit.
     * - Jika berhasil, update data petugas ke tabel user.
     *
     * @return void
     */
    public function edit_petugas()
    {
        $data['title'] = 'Edit Petugas | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $id_petugas = $this->uri->segment(3);
        $queryPetugas = "SELECT * FROM user WHERE user.id_user = '$id_petugas'";
        $data['petugas']= $this->db->query($queryPetugas)->result_array();

        $this->form_validation->set_rules('username', 'username', 'required', [
            'required' => 'Username Belum diisi!!'
        ]);

        $this->form_validation->set_rules('nama_admin', 'nama admin', 'required', [
            'required' => 'nama Belum diisi!!',
        ]);
        

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-petugas', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_user' => $this->input->post('id_user', true),
                'username' => htmlspecialchars($this->input->post('username', true)),        
                'nama_admin' => htmlspecialchars($this->input->post('nama_admin', true)),
            ];

            $this->ModelAdm->updatePetugas($data, ['id_user' => $this->input->post('id_user')]);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    petugas berhasil diubah</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/petugas');
        }

        
    }

    /**
     * Menampilkan daftar tarif dengan pagination.
     *
     * - Menampilkan data tarif dari database, 5 record per halaman.
     * - Menghitung total halaman berdasarkan jumlah data tarif.
     * - Memuat view admin/view_tarif dengan data yang diperlukan.
     *
     * @return void
     */
    public function tarif(){
        $data['title'] = 'Petugas | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        
        // Pagination setup
        $limit = 5; // Number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Get the records for the current page
        $queryTarif = "SELECT * FROM tarif ORDER BY id_tarif desc LIMIT $limit OFFSET $offset";
        $data['tarif']= $this->db->query($queryTarif)->result_array();

        // Count the total number of records to calculate the number of pages
        $totalRecords = $this->db->query("SELECT COUNT(*) as total FROM user where id_level='LVL002'")->row()->total;
        $data['totalPages'] = ceil($totalRecords / $limit);
        $data['page'] = $page;
        $data['offset'] = $offset;



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_tarif', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menghapus data tarif berdasarkan ID.
     *
     * - Memanggil model untuk menghapus tarif dengan id_tarif yang diberikan.
     * - Menampilkan pesan sukses menggunakan flashdata.
     * - Redirect ke halaman tarif.
     *
     * @param string $id ID tarif yang akan dihapus.
     * @return void
     */
    public function hapus_tarif($id)
    {
        $this->ModelAdm->hapus_tarif($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message" role="alert">tarif berhasil dihapus</div>
                                    <meta http-equiv="refresh" content="2">'
        );
        redirect('adm/tarif');
    }

    public function tambah_tarif(){
        $data['title'] = 'Tambah Tarif | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $queryIDTarif = "SELECT max(id_tarif) as maxID FROM tarif";
        $data['idT'] = $this->db->query($queryIDTarif)->result_array();
       
        $this->form_validation->set_rules('daya', 'daya', 'required', [
            'required' => 'daya Belum diisi!!'
        ]);

        $this->form_validation->set_rules('tarifperkwh', 'tarif perkwh', 'required', [
            'required' => 'tarif Belum diisi!!',
        ]);

        if ($this->form_validation->run() == false) {
            $data['tarif'] = $this->ModelCstmr->get_all_tarif();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tambah-tarif', $data);
            $this->load->view('templates/footer');
        } else {
            function bersihkanRupiah($string)
            {
                        $string = str_replace('Rp', '', $string);
                        $string = str_replace('.', '', $string);
                        return $string;
            }
            $dana = $this->input->post('tarifperkwh', true);
            $tarif = bersihkanRupiah($dana);
            $data = [
                'id_tarif' => $this->input->post('id_tarif', true),
                'daya' => $this->input->post('daya', true),
                'tarifperkwh' => $tarif,
            ];

            $this->ModelAdm->simpanData('tarif',$data);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    tarif berhasil dibuat</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/tarif');
        }
    }

    /**
     * Menampilkan form tambah tarif dan memproses input data baru.
     *
     * - Validasi form input daya dan tarifperkwh.
     * - Jika validasi gagal, tampilkan form tambah tarif kembali.
     * - Jika berhasil, simpan data tarif ke database.
     * - Menggunakan fungsi bersihkanRupiah untuk menghapus format Rupiah.
     *
     * @return void
     */
    public function edit_tarif()
    {
        $data['title'] = 'Edit Tarif | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $id_tarif = $this->uri->segment(3);
        $queryTarif = "SELECT * FROM tarif WHERE tarif.id_tarif = '$id_tarif'";
        $data['tarif']= $this->db->query($queryTarif)->result_array();

        $this->form_validation->set_rules('daya', 'daya', 'required', [
            'required' => 'daya Belum diisi!!'
        ]);

        $this->form_validation->set_rules('tarifperkwh', 'tarif perkwh', 'required', [
            'required' => 'tarif Belum diisi!!',
        ]);

        

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-tarif', $data);
            $this->load->view('templates/footer');
        } else {
            function bersihkanRupiah($string)
            {
                        $string = str_replace('Rp', '', $string);
                        $string = str_replace('.', '', $string);
                        return $string;
            }
            $dana = $this->input->post('tarifperkwh', true);
            $tarif = bersihkanRupiah($dana);
            $data = [
                'id_tarif' => $this->input->post('id_tarif', true),
                'daya' => $this->input->post('daya', true),
                'tarifperkwh' => $tarif,
            ];

            $this->ModelAdm->updateTarif($data, ['id_tarif' => $this->input->post('id_tarif')]);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    tarif berhasil diubah</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/tarif');
        }

        
    }

    /**
     * Menampilkan form edit tarif dan memproses update data tarif.
     *
     * - Mengambil data tarif berdasarkan segment URL ke-3 (id_tarif).
     * - Validasi form input daya dan tarifperkwh.
     * - Jika validasi gagal, tampilkan form edit tarif kembali.
     * - Jika berhasil, update data tarif di database.
     * - Menggunakan fungsi bersihkanRupiah untuk membersihkan format Rupiah.
     *
     * @return void
     */
    public function penggunaan()
    {
        $data['title'] = 'Penggunaan | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
         // Pagination setup
        $limit = 5; // Number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Get the records for the current page
        $queryPenggunaan = "SELECT * FROM penggunaan
                            JOIN pelanggan ON penggunaan.id_pelanggan = pelanggan.id_pelanggan 
                            ORDER BY id_penggunaan desc 
                            LIMIT $limit OFFSET $offset;";
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
        $data['penggunaan']= $this->db->query($queryPenggunaan)->result_array();

        // Count the total number of records to calculate the number of pages
        $totalRecords = $this->db->query("SELECT COUNT(*) as total FROM penggunaan")->row()->total;
        $data['totalPages'] = ceil($totalRecords / $limit);
        $data['page'] = $page;
        $data['offset'] = $offset;



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_penggunaan', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Menampilkan form tambah penggunaan dan memproses input penggunaan baru.
     *
     * - Validasi input: tahun, bulan, meter_awal, meter_akhir, dan pelanggan wajib diisi.
     * - Jika validasi gagal, tampilkan form tambah penggunaan kembali.
     * - Jika validasi berhasil, simpan data penggunaan ke database.
     *
     * @return void
     */
    public function tambah_penggunaan(){
        $data['title'] = 'Tambah Penggunaan | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $queryIDPenggunaan = "SELECT max(id_penggunaan) as maxID FROM penggunaan";
        $data['idP'] = $this->db->query($queryIDPenggunaan)->result_array();
        $data['pelanggan'] = $this->db->get('pelanggan')->result();
       
        $this->form_validation->set_rules('tahun', 'tahun', 'required', [
            'required' => 'tahun Belum diisi!!'
        ]);

        $this->form_validation->set_rules('meter_awal', 'meter awal', 'required', [
            'required' => 'meter awal Belum diisi!!',
        ]);

        $this->form_validation->set_rules('meter_akhir', 'meter_akhir', 'required', [
            'required' => 'meter akhir Belum diisi!!',
        ]);

        $this->form_validation->set_rules('bulan', 'bulan', 'required', [
            'required' => 'bulan Belum diisi!!',
        ]);
        
        $this->form_validation->set_rules('id_pelanggan', 'pelanggan', 'required', [
            'required' => 'pelanggan Belum diisi!!',
        ]);

        if ($this->form_validation->run() == false) {
            $data['pelanggan'] = $this->ModelAdm->get_all_pelanggan();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/tambah-penggunaan', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_penggunaan' => $this->input->post('id_penggunaan', true),
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'bulan' => $this->input->post('bulan', true),
                'tahun' => $this->input->post('tahun', true),
                'meter_awal' => $this->input->post('meter_awal', true),
                'meter_akhir' => $this->input->post('meter_akhir',true),
            ];

            $this->ModelAdm->simpanData('penggunaan',$data);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    penggunaan berhasil dibuat</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('adm/penggunaan');
        }
    }

    /**
     * Menghapus data penggunaan berdasarkan ID.
     *
     * - Memanggil model untuk menghapus penggunaan dengan id_penggunaan yang diberikan.
     * - Menampilkan pesan sukses menggunakan flashdata.
     * - Redirect ke halaman tarif.
     *
     * @param string $id ID penggunaan yang akan dihapus.
     * @return void
     */
    public function hapus_penggunaan($id)
    {
        $this->ModelAdm->hapus_penggunaan($id);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message" role="alert">tarif berhasil dihapus</div>
                                    <meta http-equiv="refresh" content="2">'
        );
        redirect('adm/tarif');
    }

    /**
     * Menampilkan daftar tagihan dengan pagination.
     *
     * - Mengambil data pembayaran beserta relasi pelanggan dan tagihan.
     * - Menyediakan nama bulan untuk tampilan.
     * - Menghitung total halaman untuk pagination.
     *
     * @return void
     */
    public function tagihan()
    {
        $data['title'] = 'Tagihan | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
         // Pagination setup
        $limit = 5; // Number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Get the records for the current page
        $queryTagihan = "SELECT * FROM pembayaran
                            JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan
                            JOIN tagihan ON pembayaran.id_tagihan = tagihan.id_tagihan
                            ORDER BY id_pembayaran desc 
                            LIMIT $limit OFFSET $offset;";
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
        $data['tagihan']= $this->db->query($queryTagihan)->result_array();

        // Count the total number of records to calculate the number of pages
        $totalRecords = $this->db->query("SELECT COUNT(*) as total FROM pembayaran")->row()->total;
        $data['totalPages'] = ceil($totalRecords / $limit);
        $data['page'] = $page;
        $data['offset'] = $offset;



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_tagihan', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Menampilkan daftar pembayaran dengan status tagihan 'PAID' dan pagination.
     *
     * - Mengambil data pembayaran beserta relasi pelanggan, tagihan, dan user.
     * - Menyediakan nama bulan untuk tampilan.
     * - Menghitung total halaman untuk pagination.
     *
     * @return void
     */
    public function pembayaran()
    {
        $data['title'] = 'Pembayaran | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
         // Pagination setup
        $limit = 5; // Number of records per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Get the records for the current page
        $queryPembayaran = "SELECT * FROM pembayaran
                            JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan
                            JOIN tagihan ON pembayaran.id_tagihan = tagihan.id_tagihan
                            JOIN user ON user.id_user = pembayaran.id_user WHERE tagihan.status='PAID'
                            ORDER BY id_pembayaran desc 
                            LIMIT $limit OFFSET $offset;";
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
        $data['pembayaran']= $this->db->query($queryPembayaran)->result_array();

        // Count the total number of records to calculate the number of pages
        $totalRecords = $this->db->query("SELECT COUNT(*) as total FROM pembayaran")->row()->total;
        $data['totalPages'] = ceil($totalRecords / $limit);
        $data['page'] = $page;
        $data['offset'] = $offset;



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_pembayaran', $data);
        $this->load->view('templates/footer');
    }
    
    public function print_laporan_pencairan()
    {
        // Ambil semua data dari tabel pencairan
        $data['pencairan'] = $this->db->get('pencairan')->result_array();

        // Load view cetak laporan
        $this->load->view('admin/print-laporan-pencairan', $data);
    }

    /**
     * Menampilkan halaman konfirmasi pembayaran berdasarkan ID tagihan.
     *
     * - Mengambil data pembayaran, pelanggan, dan tagihan berdasarkan id_tagihan.
     * - Menyediakan nama bulan untuk tampilan.
     *
     * @return void
     */
    public function konfirmasi()
    {
        $data['title'] = 'konfirmasi | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $id_tagihan = $this->uri->segment(3);
        $queryPembayaran = "SELECT * FROM pembayaran 
                            JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan
                            JOIN tagihan ON pembayaran.id_tagihan = tagihan.id_tagihan  WHERE pembayaran.id_tagihan = '$id_tagihan'";
        $data['konfirmasi']= $this->db->query($queryPembayaran)->result_array();
        $id_user = $this->session->userdata('id_user');
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

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/view_konfirmasi', $data);
            $this->load->view('templates/footer');
        
    }

    /**
     * Proses terima konfirmasi pembayaran.
     *
     * - Update id_user yang memproses pembayaran.
     * - Update status tagihan menjadi 'PAID'.
     * - Berikan notifikasi sukses dan redirect ke halaman tagihan.
     *
     * @return void
     */
    public function terima_konfirmasi(){

            $id_user = $this->session->userdata('id_user');
            // Ubah status tagihan jadi 'PROCESS'
            $id_pembayaran = $this->uri->segment(3);
            $this->db->where('id_pembayaran', $id_pembayaran);
            $this->db->update('pembayaran', ['id_user' => ($id_user)]);

            //Ubah status tagihan jadi 'PAID'
            $pembayaran = $this->db->get_where('pembayaran', ['id_pembayaran' => $id_pembayaran])->row();
            $id_tagihan = $pembayaran->id_tagihan;
            $this->db->where('id_tagihan', $id_tagihan);
            $this->db->update('tagihan', ['status' => 'PAID']);

            

            // Notifikasi + redirect
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Pembayaran berhasil diproses!</div>
                <meta http-equiv="refresh" content="2">'
            );

            redirect('adm/tagihan');
    }

    /**
     * Proses tolak konfirmasi pembayaran.
     *
     * - Update id_user yang memproses pembayaran.
     * - Update status tagihan menjadi 'UNPAID'.
     * - Berikan notifikasi sukses dan redirect ke halaman tagihan.
     *
     * @return void
     */
    public function tolak_konfirmasi(){

            $id_user = $this->session->userdata('id_user');
            // Ubah status tagihan jadi 'PROCESS'
            $id_pembayaran = $this->uri->segment(3);
            $this->db->where('id_pembayaran', $id_pembayaran);
            $this->db->update('pembayaran', ['id_user' => ($id_user)]);

            //Ubah status tagihan jadi 'PAID'
            $pembayaran = $this->db->get_where('pembayaran', ['id_pembayaran' => $id_pembayaran])->row();
            $id_tagihan = $pembayaran->id_tagihan;
            $this->db->where('id_tagihan', $id_tagihan);
            $this->db->update('tagihan', ['status' => 'UNPAID']);

            

            // Notifikasi + redirect
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Pembayaran berhasil diproses!</div>
                <meta http-equiv="refresh" content="2">'
            );

            redirect('adm/tagihan');
    }

    /**
     * Menampilkan halaman detail pembayaran (paid) berdasarkan id_pembayaran.
     *
     * - Mengambil data pembayaran, pelanggan, dan tagihan.
     * - Menyediakan nama bulan untuk tampilan.
     *
     * @return void
     */
    public function paid()
    {
        $data['title'] = 'konfirmasi | Mylistrik';
        $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
        $id_tagihan = $this->uri->segment(3);
        $queryPembayaran = "SELECT * FROM pembayaran 
                            JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan
                            JOIN tagihan ON pembayaran.id_tagihan = tagihan.id_tagihan  WHERE pembayaran.id_pembayaran = '$id_tagihan'";
        $data['konfirmasi']= $this->db->query($queryPembayaran)->result_array();
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

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/view_paid', $data);
            $this->load->view('templates/footer');
        
    }

    /**
     * Menampilkan halaman cetak laporan pembayaran.
     *
     * - Mengambil semua data pembayaran beserta pelanggan dan user.
     * - Menyediakan nama bulan untuk tampilan.
     * - Memuat view cetak laporan pembayaran.
     *
     * @return void
     */
    public function print_laporan_pembayaran()
    {
        // untuk tampilkan data pembayaran
        $query = "SELECT * FROM pembayaran 
                    JOIN pelanggan ON pembayaran.id_pelanggan = pelanggan.id_pelanggan
                    JOIN user ON pembayaran.id_user = user.id_user";
        $data['pembayaran'] = $this->db->query($query)->result_array();
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

        
        // Load the view for the printable page
        $this->load->view('admin/print_laporan_pembayaran', $data);
    }

    public function profile()
    {
        $data['title'] = 'Profile| Mylistrik';
        if ($this->session->userdata('username')) {
            $data['user'] = $this->ModelAdm->cekData(['username' => $this->session->userdata('username')])->row_array();
            $where = $this->session->userdata('id_user');  
            $queryPembayaran = "SELECT * FROM user WHERE id_user = '$where'";
            $data['profile']= $this->db->query($queryPembayaran)->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/profile.php', $data);
            $this->load->view('templates/footer');

        }else{
            redirect('auth');
        }
    }

    public function edit_profile()
    {
        $data = [
            'username' => htmlspecialchars($this->input->post('username')),        
            'nama_admin' => htmlspecialchars($this->input->post('nama_admin')),
        ];
         // Update data pelanggan di database
        $this->ModelAdm->updatePetugas($data, ['id_user' => $this->session->userdata('id_user')]);
        $this->session->set_userdata('username', $this->input->post('username'));
        // Tampilkan notifikasi sukses
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                user berhasil diubah</div>
            <meta http-equiv="refresh" content="2">'
        );
        // Redirect kembali ke halaman profil
        redirect('adm/profile');
    }

}