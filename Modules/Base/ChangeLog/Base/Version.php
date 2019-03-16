<?php
/**
 * Created by PhpStorm.
 * User: pcaicedo
 * Date: 19/04/18
 * Time: 02:07 PM
 */

namespace Modules\ChangeLog\Base;

//Estandar de verionado -> https://semver.org/
/**
 * Class Version
 * @package Modules\ChangeLog\Base
 */
class Version
{
    protected $version;

    protected $changes = []; //Cada Fila -> ['fecha', 'hash', 'descripcion 1']

    public function __construct()
    {
        $this->version = $this->__getVersion(get_class($this));
    }

    /**
     * Obtiene la versión
     * @param $nameClass string
     * @return string
     */
    protected function __getVersion($nameClass)
    {
        $version = explode('Version_', $nameClass);

        return join('.', explode('_', $version[1]));
    }

    /**
     * Transforma el objeto a un arreglo
     * @return array
     */
    public function toArray()
    {
        return [
            'number' => $this->version,
            'changes' => $this->changes
        ];
    }
}
