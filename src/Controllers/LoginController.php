<?php

namespace PedroBorges\Authenticator\Controllers;

use Exception;
use S;
use Kirby\Panel\Login;
use PedroBorges\Authenticator\Exceptions\InvalidOrExpiredCode;

class LoginController extends BaseController
{
    public function login()
    {
        try {
            $login = new Login();
        } catch (Exception $e) {
            return $this->layout('base', [
                'content' => $this->view('auth/error', [
                    'error' => $e->getMessage()
                ])
            ]);
        }

        if ($login->isAuthenticated()) {
            $this->redirect();
        }

        if ($login->isBlocked()) {
            return $this->layout('base', [
                'content' => $this->view('auth/block')
            ]);
        }

        $self = $this;
        $form = $this->form('auth/login', null, function ($form) use ($self, $login) {
            $data = $form->serialize();

            try {
                $self->validateTwoFactorSecret($data['security_code'], $data['username']);
                $login->attempt($data['username'], $data['password']);
                $self->redirect();
            } catch (Exception $e) {
                if ($e instanceof InvalidOrExpiredCode) {
                    $form->alert($e->getMessage());
                    $form->fields->security_code->error = true;
                } else {
                    $form->alert(l('login.error'));
                    $form->fields->username->error = true;
                    $form->fields->password->error = true;
                }
            }
        });

        return $this->layout('base', [
            'bodyclass' => 'login',
            'content'   => $this->view('auth/login', compact('form'))
        ]);
    }

    public function logout()
    {
        if ($user = panel()->user()) {
            $user->logout();
        }

        $this->redirect('login');
    }
}
