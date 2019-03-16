<?php

namespace Modules\Base\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait TraitIndexAll
{
    private static $nameFilter = 'filter';
    private static $nameView = 'view';
    private static $nameOrder = 'order';

    protected function __indexAllGetParams(Request $request)
    {
        $result = $request->all();

        if (empty($result) && !empty($request->getContent())) {
            throw new \Exception('El JSON no pudo ser convertido.');
        }

        return $result;
    }

    protected function __indexAllProcess(array $dataGet = [])
    {
        $query = $this->repository->getQuery();

        //Aplicamos el select
        $query = self::__applyProcess('__view', self::$nameView, $dataGet, $query);

        //Aplicamos los filtros
        //DB::enableQueryLog();
        $query = self::__applyProcess('__filter', self::$nameFilter, $dataGet, $query);
        //dd(DB::getQueryLog());
        //dd($query->toSql());

        //Aplicamos el ordenamiento
        $query = self::__applyProcess('__order', self::$nameFilter, $dataGet, $query);

        //Aplicamos el limit

        //Aplicamos filtros extras, como ver los update, y los by y los eliminados

        return $query;
    }

    protected function __indexAllApplyQuery($query)
    {
        $result = $this->repository->filterAll($query);

        return $result;
    }

    protected function __indexAllSent($arrResult)
    {
        if ($arrResult['meta'] && $arrResult['meta']['pagination']) {
            $arrResult['paginate'] = $arrResult['meta']['pagination'];
            unset($arrResult['meta']);
        }

        return $arrResult;
    }

    private static function __applyProcess(string $nameFunction, string $nameGet, array $dataGet, $query)
    {
        if (isset($dataGet[$nameGet])) {
            //$arrJson = json_decode($dataGet[$nameGet], true);
            $arrJson = $dataGet[$nameGet];
            $query = self::{$nameFunction}($arrJson, $query);
        }

        return $query;
    }

    private static function __view(array $arrJson, $query)
    {
        //En desarrollo

        return $query;
    }

    private static function __filter(array $arrJsonCond, $query, $typeWhere = true)
    {
        $key = key($arrJsonCond);

        switch ($key) {
            case 'and':
            case 'or':
                $arrConditions = $arrJsonCond[$key];
                $where = $key == 'and'? 'where' : 'orWhere';
                foreach ($arrConditions as $index => $arrJsonCond) {
                    $query->{$where}(function ($queryNew) use ($arrJsonCond, $key, $index) {
                        self::__filter($arrJsonCond, $queryNew, ($key == 'and' || $index == 0));
                    });
                }
                break;
            case 'cond':
                $where = $typeWhere? 'where' : 'orWhere';

                $arrSimpleCond = $arrJsonCond[$key];

                //Se cambia el id a uuid
                $field = $arrSimpleCond[0] == 'id'? 'uuid' : $arrSimpleCond[0];
                $operator = $arrSimpleCond[1];
                $value = null;

                //Puede haber operadores unarios como el not_null
                if (count($arrSimpleCond) > 2) {
                    $value = $arrSimpleCond[2];
                }

                self::__applyCondition($query, $where, $field, $operator, $value);
                break;
        }

        return $query;
    }

    private static function __applyCondition($query, $where, $field, $operator, $value)
    {
        switch ($operator) {
            case 'btw':
                $query->whereBetween($field, $value);
                break;
            case 'not_btw':
                $query->whereNotBetween($field, $value);
                break;
            case 'in':
                $query->whereIn($field, $value);
                break;
            case 'not_in':
                $query->whereNotIn($field, $value);
                break;
            case 'null':
                $query->whereNull($field);
                break;
            case 'not_null':
                $query->whereNotNull($field);
                break;
            case 'date':
                $query->whereDate($field, $value);
                break;
            case 'month':
                $query->whereMonth($field, $value);
                break;
            case 'day':
                $query->whereDay($field, $value);
                break;
            case 'year':
                $query->whereYear($field, $value);
                break;
            case 'time':
                $op = $value[0];
                $val = $value[1];

                $query->whereTime($field, $op, $val);
                break;
            case 'column':
                $op = $value[0];
                $val = $value[1];

                $query->whereColumn($field, $op, $val);
                break;
            default:
                //Operadores Simples:
                //"=", "<", ">", "<=", ">=", "<>", "!=", "<=>", "like", "like binary"
                //"not like", "ilike", "&", "|", "^", "<<", ">>", "rlike", "regexp", "not regexp", "~"
                //"~*", "!~", "!~*", "similar to", "not similar to", "not ilike", "~~*", "!~~*"

                $query->{$where}($field, $operator, $value);
        }

        return $query;
    }

    private static function __order(array $arrJson, $query)
    {
        //En desarrollo

        return $query;
    }
}
