<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb31f441915955d78e1faee4e1a1187a2
{
    public static $files = array (
        'ab54f61dc02fe4e53c617c3156846bd4' => __DIR__ . '/../..' . '/Inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JLTMRT\\Libs\\License\\' => 20,
            'JLTMRT\\Libs\\' => 12,
            'JLTMRT\\Inc\\Admin\\' => 17,
            'JLTMRT\\Inc\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JLTMRT\\Libs\\License\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Libs/License',
        ),
        'JLTMRT\\Libs\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Libs',
        ),
        'JLTMRT\\Inc\\Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Inc/Admin',
        ),
        'JLTMRT\\Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb31f441915955d78e1faee4e1a1187a2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb31f441915955d78e1faee4e1a1187a2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb31f441915955d78e1faee4e1a1187a2::$classMap;

        }, null, ClassLoader::class);
    }
}