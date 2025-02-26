<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4031540b95b1f9a4d5496683afd7eeab
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit4031540b95b1f9a4d5496683afd7eeab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4031540b95b1f9a4d5496683afd7eeab::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4031540b95b1f9a4d5496683afd7eeab::$classMap;

        }, null, ClassLoader::class);
    }
}
