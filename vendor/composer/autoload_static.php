<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3beb4ddb292011759e563f6afa28b7be
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3beb4ddb292011759e563f6afa28b7be::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3beb4ddb292011759e563f6afa28b7be::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3beb4ddb292011759e563f6afa28b7be::$classMap;

        }, null, ClassLoader::class);
    }
}