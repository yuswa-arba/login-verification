<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5922edf490f196145106ee39aff30e05
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SMSGatewayMe\\Client\\' => 20,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SMSGatewayMe\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/smsgatewayme/client/lib',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5922edf490f196145106ee39aff30e05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5922edf490f196145106ee39aff30e05::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
