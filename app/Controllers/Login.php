<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('v_login');
    }

    public function auth()
    {
        $session = session();
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $db->table('users')->getWhere(['username' => $username])->getRow();

        if ($user) {
            // 1. CEK LOCKOUT
            if ($user->lockout_time != null) {
                $waktu_kunci = strtotime($user->lockout_time);
                $waktu_sekarang = time();

                if ($waktu_sekarang < $waktu_kunci) {
                    $sisa = $waktu_kunci - $waktu_sekarang;
                    return redirect()->to(base_url('auth/portal'))->with('error', "AKUN TERKUNCI! Coba lagi dalam $sisa detik.");
                }
            }

            // 2. CEK PASSWORD (MENGGUNAKAN HASH)
            if (password_verify($password, $user->password)) {
                // BERHASIL LOGIN
                $db->table('users')->where('username', $username)->update([
                    'login_attempts' => 0,
                    'lockout_time' => null
                ]);

                $session->set(['username' => $user->username, 'logged_in' => true]);
                return redirect()->to('/admin');
            } else {
                // SALAH PASSWORD
                $salah_baru = (int)$user->login_attempts + 1;
                
                if ($salah_baru >= 3) {
                    $lock_until = date('Y-m-d H:i:s', strtotime('+1 minute'));
                    $db->table('users')->where('username', $username)->update([
                        'login_attempts' => $salah_baru,
                        'lockout_time' => $lock_until
                    ]);
                    return redirect()->to(base_url('auth/portal'))->with('error', "Terlalu banyak percobaan! Akun dikunci 1 menit.");
                } else {
                    $db->table('users')->where('username', $username)->update([
                        'login_attempts' => $salah_baru
                    ]);
                    return redirect()->to(base_url('auth/portal'))->with('error', "Username atau Password Salah! (Percobaan ke-$salah_baru)");
                }
            }
        } else {
            // USERNAME TIDAK ADA
            return redirect()->to(base_url('auth/portal'))->with('error', 'Username atau Password Salah!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/')); 
    }

    public function lupa_password() 
    { 
        return view('v_lupa_password'); 
    }

    public function proses_lupa_password()
    {
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $jawaban = $this->request->getPost('jawaban');
        $new_password = $this->request->getPost('new_password');

        $user = $db->table('users')->getWhere([
            'username' => $username,
            'jawaban_keamanan' => $jawaban
        ])->getRow();

        if ($user) {
            // Simpan password dalam bentuk Hash agar aman
            $hash_baru = password_hash($new_password, PASSWORD_DEFAULT);
            $db->table('users')->where('username', $user->username)->update([
                'password' => $hash_baru,
                'login_attempts' => 0,
                'lockout_time' => null
            ]);
            return redirect()->to(base_url('auth/portal'))->with('success', 'Password berhasil diperbarui!');
        } else {
            return redirect()->to(base_url('auth/lupa-password'))->with('error', 'Jawaban keamanan salah!');
        }
    }
}