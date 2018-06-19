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
        $url = $this->getSecretUrl($user->username, $key);

        $self = $this;
        $form = $this->form('settings/turn-on', compact('key', 'url'), function ($form) use ($self, $user) {
            try {
                // TODO: Ask code before enabling 2-step verification
                $user->update([
                    'authenticatorSecret' => S::pull('authenticator_key')
                ]);

                panel()->notify(l('authenticator.turnOn.success'));
            } catch (Exception $e) {
                panel()->alert(l('authenticator.turnOn.error'));
            }

            panel()->redirect('users/' . $user->username . '/edit');
        });

        S::set('authenticator_key', $key);

        return $this->modal('settings/index', compact('form'));
    }

    public function turnOff($username)
    {
        $user = $this->findUser($username);

        $self = $this;
        $form = $this->form('settings/turn-off', [], function ($form) use ($self, $user) {
            $data = $form->serialize();

            try {
                $self->validateTwoFactorSecret($data['security_code'], $user->username);

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
