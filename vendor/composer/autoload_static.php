<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc4c18db373ff26146736e56d851f765b
{
    public static $files = array (
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        'bd9634f2d41831496de0d3dfe4c94881' => __DIR__ . '/..' . '/symfony/polyfill-php56/bootstrap.php',
        '4ae513dcd6c6781fd946d90523cfc740' => __DIR__ . '/../..' . '/src/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Util\\' => 22,
            'Symfony\\Polyfill\\Php56\\' => 23,
        ),
        'P' => 
        array (
            'PragmaRX\\Google2FA\\Tests\\' => 25,
            'PragmaRX\\Google2FA\\' => 19,
            'PedroBorges\\Authenticator\\' => 26,
            'ParagonIE\\ConstantTime\\' => 23,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Util\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-util',
        ),
        'Symfony\\Polyfill\\Php56\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php56',
        ),
        'PragmaRX\\Google2FA\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/pragmarx/google2fa/tests',
        ),
        'PragmaRX\\Google2FA\\' => 
        array (
            0 => __DIR__ . '/..' . '/pragmarx/google2fa/src',
        ),
        'PedroBorges\\Authenticator\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc4c18db373ff26146736e56d851f765b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc4c18db373ff26146736e56d851f765b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
