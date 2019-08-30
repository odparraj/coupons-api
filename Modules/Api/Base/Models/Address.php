<?php
/**
 * Contains the Address model class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-26
 *
 */

namespace Modules\Api\Base\Models;

use Konekt\AppShell\Models\Address as BaseAddress;
use Vanilo\Contracts\Address as AddressContract;
use Vanilo\Support\Traits\AddressModel;

class Address extends BaseAddress implements AddressContract
{
    use AddressModel;
}
