<?php

namespace PedroBorges\Authenticator\Controllers;

use Data;
use Exception;
use Panel;
use Password;
use Url;
use Kirby\Panel\Controllers\Base;
use PedroBorges\Authenticator\Authenticator;
use PedroBorges\Authenticator\Exceptions\InvalidBackupCode;
use PedroBorges\Authenticator\Exceptions\InvalidOrExpiredCode;
use PedroBorges\Authenticator\View;
use PragmaRX\Google2FA\Google2FA;

class BaseController extends Base
{
    protected $logFile;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->authenticator = new Google2FA();
        $this->roots         = Authenticator::instance()->roots();
        $this->logFile       = kirby()->roots()->accounts() . DS . '.logins';
    }

    protected function validateUserSecret($secret, $username)
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

    protected function validateSecret($secret, $key)
    {
        if (! $this->authenticator->verifyKey($key, $secret)) {
            throw new InvalidOrExpiredCode();
        }
    }

    protected function validateBackupCode($data)
    {
        $user = site()->users()->find($data['username']);

        if (! Password::match($data['password'], $user->password)) {
            return;
        }

        if ($user->authenticatorBackup !== $data['backup_code']) {
            throw new InvalidBackupCode();
        }

        // Disable 2-steps verification
        $user->update([
            'authenticatorSecret' => null,
            'authenticatorTimestamp' => null,
            'authenticatorBackup' => null,
        ]);

        return true;
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

    protected function log($data = []) {
        $newData = array_merge($this->logData(), $data);

        return Data::write($this->logFile, $newData, 'json');
    }

    protected function logData($key = null) {
        $data = Data::read($this->logFile, 'json');

        if ($key) {
            return isset($data[$key]) ? $data[$key] : null;
        }

        return $data;
    }
}
