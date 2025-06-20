<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

public function attemptLogin()
{
    $session = session();
    $model = new UserModel();

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $user = $model->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'logged_in' => true,
        ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/posts');
                } else {
                    return redirect()->to('/forum');
                }
    } else {
        return redirect()->back()->with('error', 'Invalid login');
    }
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
