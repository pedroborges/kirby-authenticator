<?php

namespace PedroBorges\Authenticator\Controllers;

use Exception;
use Panel;
use Url;
use Kirby\Panel\Controllers\Base;
use PedroBorges\Authenticator\Authenticator;
use PedroBorges\Authenticator\Exceptions\InvalidOrExpiredCode;
use PedroBorges\Authenticator\View;
use PragmaRX\Google2FA\Google2FA;

class BaseController extends Base
{
    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->authenticator = new Google2FA();
        $this->roots         = Authenticator::instance()->roots();
    }

    protected function validateTwoFactorSecret($secret, $username)
    {
        $user = site()->users()->find($username);

        if (! $user->authenticatorSecret) {
            return;
        }

        $timestamp = $this->authenticator->verifyKeyNewer(
            $user->authenticatorSecret,
            $secret,
            $user->authenticatorTimestamp
        );

        // Prevent secret from being used more than once
        if (false !== $timestamp) {
            $user->update([
                'authenticatorTimestamp' => $timestamp
            ]);
        } else {
            throw new InvalidOrExpiredCode();
        }
    }

    protected function findUser($username)
    {
        $user = site()->users()->find($username);

        if ($user != site()->user() && ! site()->user()->isAdmin()) {
            throw new Exception(l('users.form.error.update.rights'));
        }

        return $user;
    }

    protected function getSecretKey()
    {
        return $this->authenticator->generateSecretKey();
    }

    protected function getSecretUrl($username, $secret)
    {
        return $this->authenticator->getQRCodeUrl(
            Url::host(),
            $username,
            $secret
        );
    }

    public function form($id, $data = [], $submit = null)
    {
        $pluginForm = Authenticator::instance()->roots()->forms() . DS . $id . '.php';

        // Default to panel forms
        $root = file_exists($pluginForm)
            ? Authenticator::instance()->roots()->forms()
            : Panel::instance()->roots()->forms();

        $file = $root . DS . $id . '.php';

        return panel()->form($file, $data, $submit);
    }

    public function view($file, $data = [])
    {
        return new View($file, $data);
    }
}
