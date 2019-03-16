<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Base\Repositories\RepositoryAbstract;

use Modules\Base\Http\Controllers\Traits\TraitIndex;
use Modules\Base\Http\Controllers\Traits\TraitIndexAll;
use Modules\Base\Http\Controllers\Traits\TraitStore;
use Modules\Base\Http\Controllers\Traits\TraitUpdate;
use Modules\Base\Http\Controllers\Traits\TraitDestroy;

class BaseController extends Controller
{
    use TraitIndex, TraitIndexAll, TraitStore, TraitUpdate, TraitDestroy;

    protected $repository;

    protected $arrValidate = [];
    protected $arrValidateUpdate = [];

    //Array utilizado para especificar las conversiones de uuid a id, se especifica como clave el atributo a convertitr
    //y como valor la clase del modelo al que hace referencia 
    protected $uuidToId= [];

    public function __construct(RepositoryAbstract $repository)
    {
        if (empty($this->arrValidate)) {
            throw new \Exception('El arreglo arrValidade no puede ser vacio.');
        } else {
            //Creo el validate para el update y los transformo a array el validate base
            foreach ($this->arrValidate as $key => $value) {
                //Se estandariza a arreglo
                if (gettype($value) == 'string') {
                    $this->arrValidate[$key] = explode('|', $value);
                }

                //Se quita el require que no es necesario para el update
                $this->arrValidateUpdate[$key] = [];
                foreach ($this->arrValidate[$key] as $index => $rule) {
                    if ($rule != 'required') {
                        array_push($this->arrValidateUpdate[$key], $rule);
                    }
                }
            }
        }
        
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        //Obtengo la data
        $dataGet = $this->__indexGetParams($request);

        //Ejecuto del filtro
        $arrResult = $this->__indexProcess($dataGet);

        //Procesamos la respuesta
        return $this->__indexSent($arrResult);
    }

    public function indexAll(Request $request)
    {
        //Obtengo los parametros
        $dataGet = $this->__indexAllGetParams($request);

        //Obtenemos el query transformado según los filtros enviados
        $query = $this->__indexAllProcess($dataGet);

        //Aplicamos el filtro
        $arrResult = $this->__indexAllApplyQuery($query);

        //Procesamos la respuesta
        return $this->__indexAllSent($arrResult);
    }

    public function show(Request $request, $uuid)
    {
        return response()->json($this->repository->find($uuid));
    }

    public function store(Request $request)
    {
        //Validamos la data
        $this->__storeValid($request);
        
        //Obtenemos la información
        $data = $this->__storeGet($request);

        //Procesamos la data
        $data = $this->__storeProcess($data);

        //Tranformacion de uuid a id
        $data = $this->__transformIDs($data);

        //Guardamos los datos
        $result = $this->__storeSave($data);

        //Retornamos el resultado
        return $this->__storeSent($result);
    }

    public function update(Request $request, $uuid)
    {
        //Validamos la data
        $this->__updateValid($request);

        //Obtenemos la información
        $data = $this->__updateGet($request);

        //Procesamos la data
        $data = $this->__updateProcess($data);

        //Tranformacion de uuid a id
        $data = $this->__transformIDs($data);

        //Guardamos los datos
        $result = $this->__updateSave($uuid, $data);

        //Retornamos el resultado
        return $this->__updateSent($result);
    }

    public function destroy(Request $request, $uuid)
    {
        //Eliminamos el elemento
        $result = $this->__destroySave($uuid);

        //Retornamos el resultado
        return $this->__destroySent($result);
    }

    private function __transformIDs($data)
    {
        foreach ($this->uuidToId as $key_uuid => $class) {
            if (isset($data[$key_uuid])) {
                $model = $class::whereUuid($data[$key_uuid])->first(['id']);
                $data[$key_uuid] = $model->id;
            }
        }
        return $data;
    }
}
