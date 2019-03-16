<?php
/**
 * Created by PhpStorm.
 * User: pcaicedo
 * Date: 19/04/18
 * Time: 02:34 PM
 */

namespace Modules\ChangeLog\Versions;

use Modules\ChangeLog\Base\Version;

class Version_1_0_0 extends Version
{
    protected $changes = [
        ['fecha', 'hash', 'descripcion 1'],
        ['fecha', 'hash', 'descripcion 2']
    ];
}
