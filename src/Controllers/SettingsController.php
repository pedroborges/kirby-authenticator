<?php

namespace PedroBorges\Authenticator\Controllers;

use Exception;
use S;
use PedroBorges\Authenticator\Exceptions\InvalidOrExpiredCode;

class SettingsController extends BaseController
{
    public function turnOn($username)
    {
        $user = $this->findUser($username);

        $key = $this->getSecretKey($user->username);
        $url = $this->getSecretUrl($user->username, S::get('authenticator_key', $key));

        $self = $this;
        $form = $this->form('settings/turn-on', compact('user', 'url'), function ($form) use ($self, $user) {
            $data = $form->serialize();

            try {
                $self->validateSecret($data['security_code'], S::get('authenticator_key'));

                $user->update([
                    'authenticatorSecret' => S::pull('authenticator_key')
                ]);

                $self->notify(l('authenticator.turnOn.success'));
                $self->redirect('users/' . $user->username . '/edit');
            } catch (Exception $e) {
                if ($e instanceof InvalidOrExpiredCode) {
                    $form->alert($e->getMessage());
                    $form->fields->security_code->error = true;
                } else {
                    $self->alert(l('authenticator.turnOn.error'));
                }
            }
        });

        // Prevent setting new key when
        // security code confirmation fails
        if (! S::get('authenticator_key')) {
            S::set('authenticator_key', $key);
        }

        return $this->modal('settings/index', compact('form'));
    }

    public function turnOff($username)
    {
        $user = $this->findUser($username);

        $self = $this;
        $form = $this->form('settings/turn-off', compact('user'), function ($form) use ($self, $user) {
            $data = $form->serialize();

            try {
                $self->validateUserSecret($data['security_code'], $user->username);

                $user->update([
                    'authenticatorSecret' => null,
                    'authenticatorTimestamp' => null
                ]);

                $self->notify(l('authenticator.turnOff.success'));
                $self->redirect('users/' . $user->username . '/edit');
            } catch (Exception $e) {
                if ($e instanceof InvalidOrExpiredCode) {
                    $form->alert($e->getMessage());
                    $form->fields->security_code->error = true;
                } else {
                    $self->alert(l('authenticator.turnOff.error'));
                }
            }
        });

        return $this->modal('settings/index', compact('form'));
    }
}
