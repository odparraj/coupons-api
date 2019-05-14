<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{    
    public function changeLog()
    {
        $project = [
            'name' => 'Terapp Admin - API',
            'description' => 'Terapp Admin',
            'company' => 'Bytersoft',
            'version' => '1.0.4',
            'changeLog' => [
                '1.0.0' => 'Initial version'
            ]
        ];
        
        return view('welcome', ['project' => $project]);
    }
    
}
