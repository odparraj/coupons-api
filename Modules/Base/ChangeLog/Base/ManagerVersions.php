<?php
/**
 * Created by PhpStorm.
 * User: pcaicedo
 * Date: 19/04/18
 * Time: 02:08 PM
 */

namespace Modules\ChangeLog\Base;

use Modules\ChangeLog\Versions\Version_1_0_0;
use Modules\ChangeLog\Versions\Version_1_2_0;
use Modules\ChangeLog\Versions\Version_2_0_0;

class ManagerVersions
{
    private $nameApp = 'Health Checks';
    private $arrVersions = [
        Version_1_0_0::class,
        Version_2_0_0::class,
        Version_1_2_0::class
    ];

    public function __construct()
    {
        //Ordenamos lexicográficamente
        sort($this->arrVersions);
    }

    public function versions($strVersion)
    {
        $versions = $this->__filter($strVersion);

        return [
            'name' => $this->nameApp,
            'requires' => [
                'Core' => '1.0.0'
            ],
            'versions' => $versions
        ];
    }

    private function __filter($strVersion)
    {
        $strVersionAux = join('_', explode('.', $strVersion));
        $versions = [];

        foreach ($this->arrVersions as $index => $nameClass) {
            //Verifico cada una de las clases
            if (preg_match("/Version_$strVersionAux/i", $nameClass)) {
                array_push($versions, app($nameClass)->toArray());
            }
        }

        return $versions;
    }
}
