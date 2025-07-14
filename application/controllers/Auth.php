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
class Auth extends CI_Controller
{
    /**
     * Konstruktor, load library form_validation
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }


    /**
     * Halaman login pelanggan, validasi form, dan proses login.
     * Jika validasi gagal, tampilkan halaman login.
     * Jika berhasil, panggil _login().
     *
     * @return void
     */
    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim', [
            'required' => 'username Harus diisi!!',
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password Harus diisi'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login | Mylistrik';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login-cstmr');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    /**
     * Proses autentikasi login pelanggan.
     * Cek username dan password, set session jika berhasil.
     *
     * @return void
     */
    private function _login()
    {
        $username = htmlspecialchars($this->input->post('username', true));
        $password = $this->input->post('password', true);

        $pelanggan = $this->ModelCstmr->cekData(['username' => $username])->row_array();

        if ($pelanggan) {
            //cek password
            if (password_verify($password, $pelanggan['password'])) {
                $data = ['id_pelanggan' => $pelanggan['id_pelanggan'],'username' => $pelanggan['username'], 'nama_pelanggan' => $pelanggan['nama_pelanggan'], 'password' => $pelanggan['password']];
                $this->session->set_userdata($data);
                    redirect('pelanggan');
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-message" role="alert">Password salah!!</div>
                    <meta http-equiv="refresh" content="2">'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-message" role="alert">Username tidak terdaftar!!</div>
                <meta http-equiv="refresh" content="2">'
            );
            redirect('auth');
        }
    }


    /**
     * Halaman registrasi pelanggan.
     * Validasi input, simpan data pelanggan baru jika valid.
     *
     * @return void
     */
    public function register()
    {

        $queryIDUser = "SELECT max(id_pelanggan) as maxID FROM pelanggan";
        $data['idP'] = $this->db->query($queryIDUser)->result_array();


        $this->form_validation->set_rules('username', 'Nama Lengkap', 'required', [
            'required' => 'Nama Belum diisi!!'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [ 
            'required' => 'Password Belum diisi!!',
            'min_length' => 'Password Terlalu Pendek'
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
            $data['title'] = 'Register | Mylisrtrik';
            $data['tarif'] = $this->ModelCstmr->get_all_tarif();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register-cstmr', $data);
            $this->load->view('templates/auth_footer');
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

            $this->ModelCstmr->simpanData($data);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success alert-message" role="alert">Selamat!! 
                    akun anda sudah dibuat. Silahkan login!</div>
                    <meta http-equiv="refresh" content="2">'
            );
            redirect('auth');
        }
    }

    /**
     * Halaman login admin.
     * Validasi form dan proses login admin.
     *
     * @return void
     */
    public function loginadm()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim', [
            'required' => 'username Harus diisi!!',
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password Harus diisi'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login | Mylistrik';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login-admin');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_loginadm();
        }
    }

    /**
     * Proses autentikasi login admin.
     * Cek username dan password, set session jika berhasil.
     *
     * @return void
     */
    private function _loginadm()
    {
        $username = htmlspecialchars($this->input->post('username', true));
        $password = $this->input->post('password', true);

        $user = $this->ModelAdm->cekData(['username' => $username])->row_array();

        if ($user) {
            //cek password
            if (password_verify($password, $user['password'])) {
                $data = ['username' => $user['username'], 'id_user' => $user['id_user'], 'password' => $user['password'], 'nama_admin' => $user['nama_admin'], 'id_level' => $user['id_level']];
                $this->session->set_userdata($data);
                redirect('adm');
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-message" role="alert">Password salah!!</div>
                    <meta http-equiv="refresh" content="2">'
                );
                redirect('auth/loginadm');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-message" role="alert">Username tidak terdaftar!!</div>
                <meta http-equiv="refresh" content="2">'
            );
            redirect('auth');
        }
    }

    /**
     * Logout user/admin dan destroy session.
     *
     * @return void
     */
    public function logout()
    {
        $this->session->sess_destroy();

        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success" role="alert">Kamu berhasil logout</div>
            <meta http-equiv="refresh" content="2">'
        );

        redirect('auth');
    }
}
