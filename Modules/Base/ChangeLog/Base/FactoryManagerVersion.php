<?php
/**
 * Created by PhpStorm.
 * User: pcaicedo
 * Date: 19/04/18
 * Time: 02:23 PM
 */

namespace Modules\ChangeLog\Base;

class FactoryManagerVersion
{
    private static $manager =  null;

    public static function createManagerVersions()
    {
        if (is_null(self::$manager)) {
            self::$manager = new ManagerVersions();
        }

        return self::$manager;
    }
}