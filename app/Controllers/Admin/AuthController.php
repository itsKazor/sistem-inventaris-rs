<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('is_logged_in') && session()->get('role') === 'admin') {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('admin/auth/login', [
            'title' => 'Login Administrator',
        ]);
    }

    public function attemptLogin()
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Harap isi username/email dan password.');
        }

        $loginInput = $this->request->getPost('login');
        $password   = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->findByUsernameOrEmail($loginInput);

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username/email atau password salah.');
        }

        session()->set([
            'user_id'      => $user['id'],
            'name'         => $user['name'],
            'username'     => $user['username'],
            'email'        => $user['email'],
            'role'         => $user['role'],
            'is_logged_in' => true,
        ]);

        return redirect()->to(base_url('admin/dashboard'))->with('success', 'Selamat datang kembali, ' . $user['name']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'))->with('success', 'Anda telah berhasil logout.');
    }
}
