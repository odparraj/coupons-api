<?php
/**
 * Created by PhpStorm.
 * User: pcaicedo
 * Date: 19/04/18
 * Time: 12:13 PM
 */

namespace Modules\ChangeLog\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\ChangeLog\Base\FactoryManagerVersion;

class ChangeLogController extends Controller
{
    private $managerVersions = null;

    public function __construct()
    {
        $this->managerVersions = FactoryManagerVersion::createManagerVersions();
    }

    public function index(Request $request)
    {
        return $this->indexVersion($request, '');
    }

    public function indexVersion(Request $request, string $version)
    {
        return $this->managerVersions->versions($version);
    }
}