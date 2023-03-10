<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc917e9788979f3a594824ff29513b828
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc917e9788979f3a594824ff29513b828::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc917e9788979f3a594824ff29513b828::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc917e9788979f3a594824ff29513b828::$classMap;

        }, null, ClassLoader::class);
    }
}
