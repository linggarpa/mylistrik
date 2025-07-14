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

    /**
     * Menampilkan halaman profil pelanggan.
     *
     * Menyiapkan data pelanggan dan profil berdasarkan sesi login, 
     * lalu memuat tampilan profil pelanggan jika user sudah login.
     * Jika tidak login, akan diarahkan ke halaman autentikasi.
     *
     * @return void
     */
    public function profile()
    {
        $data['title'] = 'Profile| Mylistrik';
        if ($this->session->userdata('username')) {
            $data['pelanggan'] = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();
            $where = ['id_pelanggan' =>$this->session->userdata('id_pelanggan')];  
            $data['profile'] = $this->ModelCstmr->viewprofile($where);
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('pelanggan/profile.php', $data);
            $this->load->view('templates/user_footer');

        }else{
            redirect('auth');
        }
    }

    /**
     * Mengedit data profil pelanggan.
     *
     * Validasi input terlebih dahulu. Jika lolos validasi, update data
     * pelanggan ke database berdasarkan `id_pelanggan` dari session.
     *
     * @return void
     */
    public function edit_profile()
    {
         // Validasi form input
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

         // Jika validasi gagal, redirect kembali ke halaman profil
        if ($this->form_validation->run() == false) {
            redirect('pelanggan/profile');
        }else{
             // Ambil data dari form input
             $data = [
                'username' => htmlspecialchars($this->input->post('username', true)),        
                'nomor_kwh' => htmlspecialchars($this->input->post('nomor_kwh', true)),
                'nama_pelanggan' => htmlspecialchars($this->input->post('nama_pelanggan', true)),
                'alamat' => $this->input->post('alamat', true),
                'id_tarif' => $this->input->post('tarif', true),
            ];
             // Update data pelanggan di database
            $this->ModelCstmr->updatePelanggan($data, ['id_pelanggan' => $this->session->userdata('id_pelanggan')]);
            // Tampilkan notifikasi sukses
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    pelanggan berhasil diubah</div>
                    <meta http-equiv="refresh" content="2">'
            );
            // Redirect kembali ke halaman profil
            redirect('pelanggan/profile');
        }
    }
    /**
     * Mengubah password pelanggan.
     *
     * Mengecek validitas password lama dan kesesuaian konfirmasi password baru,
     * lalu memperbarui password pelanggan ke database jika semua validasi terpenuhi.
     *
     * @return void
     */
    public function ubah_password()
    {
    $data['title'] = 'Profile | Mylistrik';

    if (!$this->session->userdata('username')) {
        redirect('auth');
    }

    // Ambil data pelanggan & profil
    $data['pelanggan'] = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();
    $where = ['id_pelanggan' => $this->session->userdata('id_pelanggan')];  
    $data['profile'] = $this->ModelCstmr->viewprofile($where);

    // Cek apakah ini request POST (submit form)
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
        $password_lama       = $this->input->post('password_lama');
        $password_baru       = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        // Ambil hash password dari database
        $user = $this->ModelCstmr->cekData(['username' => $this->session->userdata('username')])->row_array();

        // Verifikasi password lama
        if (!password_verify($password_lama, $this->session->userdata('password'))) {
            $this->session->set_flashdata('error', 'Password lama salah. <meta http-equiv="refresh" content="2">');
            redirect('pelanggan/ubah_password');
        }

        // Cek konfirmasi password
        if ($password_baru !== $konfirmasi_password) {
            $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok. <meta http-equiv="refresh" content="2">');
            redirect('pelanggan/ubah_password');
        }

        // Update password baru (hash)
        $hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);
        $this->db->where('id_pelanggan', $this->session->userdata('id_pelanggan'));
        $this->db->update('pelanggan', ['password' => $hash_baru]);

        $this->session->set_flashdata('pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    pelanggan berhasil diubah</div>
                    <meta http-equiv="refresh" content="2">');
        redirect('pelanggan/profile');
    }

        // Load view
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_navbar', $data);
        $this->load->view('pelanggan/ubah_password.php', $data);
        $this->load->view('templates/user_footer');
    }
    
}