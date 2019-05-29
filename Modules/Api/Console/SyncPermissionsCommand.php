<?php
/**
 * Created by PhpStorm.
 * User: oparra
 * Date: 5/9/19
 * Time: 10:42 AM
 */

namespace Modules\Api\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Api\Entities\PermissionModel;

class SyncPermissionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'permissions:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza los permisos de acuerdo a los modulos configurados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Start Command");
        $middleware = config('sync_permissions.middleware');

        $routeCollection = Route::getRoutes();
        $routes= [];

        foreach ($routeCollection as $route) {

            $isPermissible= collect($middleware)->contains(function ($item) use($route){
                return in_array($item, $route->middleware());
            });

            if($isPermissible){
                $routes[] =[
                    'name' => $route->getActionName(),
                    'middleware'=> $route->middleware()
                ];
            }
        }

        $permissions= [];
        $this->info("synchronizing routes\n");

        foreach ($routes as $route){
            $permissions[] = $route['name'];
            PermissionModel::findOrCreate($route['name'],'api');
            $this->info("Sync permission : {$route['name']}");
        }

        $permissionsToDelete= PermissionModel::whereNotIn('name',$permissions)->where('guard_name','api')->get();
        foreach ($permissionsToDelete as $permission){
            $this->info("Deleting {$permission->name}");
            $permission->forceDelete();
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
