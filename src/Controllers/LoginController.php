<?php

namespace PedroBorges\Authenticator\Controllers;

use Exception;
use S;
use Kirby\Panel\Login;
use PedroBorges\Authenticator\Exceptions\InvalidBackupCode;
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

        $attempts = $this->logData('sc_attempts');
        $canUseBackupCode = $attempts && $attempts >= 3;

        $self = $this;
        $form = $this->form('auth/login', compact('canUseBackupCode'), function ($form) use ($self, $login, $canUseBackupCode) {
            $data = $form->serialize();
            $backupCodeWasUsed = false;

            try {
                if ($canUseBackupCode) {
                    $backupCodeWasUsed = $self->validateBackupCode($data);
                } else {
                    $self->validateUserSecret($data['security_code'], $data['username']);
                }

                $login->attempt($data['username'], $data['password']);

                if ($backupCodeWasUsed) {
                    $self->alert(l('authenticator.turnOff.success'));
                    $self->redirect('users/' . site()->user()->username . '/edit');
                }

                $self->redirect();
            } catch (Exception $e) {
                if ($e instanceof InvalidOrExpiredCode) {
                    $form->alert($e->getMessage());
                    $form->fields->security_code->error = true;
                    $self->logAttempt();
                } elseif ($e instanceof InvalidBackupCode) {
                    $form->alert($e->getMessage());
                    $form->fields->backup_code->error = true;
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

    public function logAttempt()
    {
        $data = $this->logData();

        $data['sc_attempts'] = isset($data['sc_attempts'])
            ? $data['sc_attempts'] + 1
            : 1;

        $this->log($data);
    }
}
