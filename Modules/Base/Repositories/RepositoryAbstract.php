<?php

namespace Modules\Base\Repositories;

use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

use Modules\Base\Transformers\SimpleTransformer;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected $manager;

    public $paginate;

    protected $tSimple = SimpleTransformer::class;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;

        $this->paginate = config('odavila.paginate');
    }

    /**
     * @param array $attributes filters
     * @param string $orderBy order field
     * @param string $direction ASC|DESC
     * @return array
     */
    public function filterAll($query)
    {
        $m = $query->paginate($this->paginate);

        $collection = new Collection(
            $m->getCollection(),
            $this->getTransformer()
        );

        $collection->setPaginator(new IlluminatePaginatorAdapter($m));

        //Se procesa el formato de salida
        return $this->manager->createData($collection)->toArray();
    }

    public function filter($dataGet)
    {
        $query = $this->getModel()->filter($dataGet);
        
        return $this->filterAll($query);
    }

    public function getQuery()
    {
        return $this->getModel()->query();
    }
    //cambio de protegido a publico para probar funcionalidad de la maquina de estados
    public function getModel()
    {
        return app($this->model);
    }

    protected function getTransformer()
    {
        return app($this->transformer);
    }

    protected function getSimpleTransformer()
    {
        return app($this->tSimple);
    }

    public function store(array $attributes)
    {
        
        $resource = $this->getModel()->create($attributes);
        
        return $this->manager->createData(new Item(
            $resource,
            $this->getSimpleTransformer()
        ))->toArray();
    }

    public function update($uuid, array $attributes)
    {
        $insModel = $this->getModel()
            ->whereUuid($uuid)
            ->first();

        if ($insModel instanceof $this->model) {
            $insModel->update($attributes);
            $insModel->save();

             return $this->manager->createData(
                new Item(
                    $insModel,
                    $this->getSimpleTransformer()
                )
            )->toArray();
        }
    }

    public function all($order = 'DESC')
    {
        $resource = $this->getModel()
            ->orderBy('id', $order)
            ->get();

        return $this->manager->createData(new Collection(
            $resource,
            $this->getTransformer()
        ))->toArray();
    }

    public function paginate($order = 'DESC')
    {
        $resource = $this->getModel()
            ->orderBy('created_at', $order)
            ->paginate($this->paginate);

        $collection = new Collection(
            $resource->getCollection(),
            $this->getTransformer()
        );

        $collection->setPaginator(new IlluminatePaginatorAdapter($resource));

        return $this->manager->createData($collection)->toArray();
    }

    public function find($uuid)
    {
        $resource = $this->getModel()
            ->whereUuid($uuid)
            ->first();

        if ($resource instanceof $this->model) {
            return $this->manager->createData(
                new Item(
                    $resource,
                    $this->getTransformer()
                )
            )->toArray();
        }

        return abort(404);
    }
    
    public function version($uuid, $version)
    {
        $insModel = $this->getModel()
            ->whereUuid($uuid)
            ->first();
        
        if ($insModel instanceof $this->model) {
            $insModel = $insModel->getVersion($version);
            
            if ($insModel instanceof $this->model) {
                return $this->manager->createData(
                    new Item(
                        $insModel,
                        $this->getTransformer()
                    )
                )->toArray();
            } else {
                throw new \Exception('Versión no encontrada', 404);
            }
        } else {
            throw new \Exception('Elemento no encontrado', 404);
        }
    }

    public function destroy($uuid)
    {
        $insModel = $this->getModel()
            ->whereUuid($uuid)
            ->first();

        if ($insModel instanceof $this->model) {

            $arrResult = $this->manager->createData(
                new Item(
                    $insModel,
                    $this->getSimpleTransformer()
                )
            )->toArray();

            $arrResult['error'] = !$insModel->delete();

            return $arrResult;
        } else {
            throw new \Exception('Elemento no encontrado', 404);
        }
    }
}