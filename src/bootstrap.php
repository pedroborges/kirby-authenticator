<?php

use PedroBorges\Authenticator\Authenticator;
use PedroBorges\Authenticator\Controllers\LoginController;
use PedroBorges\Authenticator\Controllers\SettingsController;

function authenticator()
{
    return Authenticator::instance();
}

kirby()->set('field', 'authenticator', authenticator()->roots()->fields() . DS . 'authenticator');
kirby()->set('field', 'qrcode', authenticator()->roots()->fields() . DS . 'qrcode');

// Register users/default blueprint in case one does not exist inside site/blueprints
if (
    ! file_exists(kirby()->roots()->blueprints() . DS . 'users' . DS . 'default.yml')
    && ! file_exists(kirby()->roots()->blueprints() . DS . 'users' . DS . 'default.yaml')
) {
    kirby()->set(
        'blueprint',
        'users/default',
        authenticator()->roots()->blueprints() . DS . 'users' . DS . 'default.yml'
    );
}

panel()->routes([
    [
        'pattern' => '(login)',
        'method'  => 'GET|POST',
        'filter'  => 'isInstalled',
        'action'  => function () {
            return (new LoginController)->login();
        }
    ],
    [
        'pattern' => 'login.css',
        'method'  => 'GET',
        'action'  => function () {
            require_once(panel()->roots()->controllers() . DS . 'assets.php');

            return (new AssetsController)->other('authenticator', 'css/authenticator.css');
        }
    ],
    [
        'pattern' => '(logout)',
        'method'  => 'GET',
        'filter'  => 'auth',
        'action'  => function () {
            return (new LoginController)->logout();
        }
    ],
    [
        'pattern' => 'users/(:any)/two-steps/on',
        'method'  => 'GET|POST',
        'filter'  => 'auth',
        'action'  => function ($username) {
            return (new SettingsController)->turnOn($username);
        }
    ],
    [
        'pattern' => 'users/(:any)/two-steps/off',
        'method'  => 'GET|POST',
        'filter'  => 'auth',
        'action'  => function ($username) {
            return (new SettingsController)->turnOff($username);
        }
    ],
]);
