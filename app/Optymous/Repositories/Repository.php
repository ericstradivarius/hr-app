<?php namespace App\Optymous\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class Repository {
    protected $request;

    public function getPerPageFrom(Request $request) {

        $request->has('per_page') ? $perPage = $request->input('per_page') : $perPage = 10;
        return $this->getModelFrom($request)->paginate($perPage);
    }

    public function getCountFrom(Request $request, $groupBy = null, $granularity = null) {

        if($groupBy) {
            if($granularity) {
                return $this->getModelFrom($request)
                    ->select(DB::raw("DATE_FORMAT($groupBy, '$granularity') as value, count(*) as count"))
                    ->groupBy(DB::raw("DATE_FORMAT($groupBy, '$granularity')"))
                    ->get();
            }
            return $this->getModelFrom($request)
                ->select(DB::raw("$groupBy as value, count(*) as count"))
                ->groupBy($groupBy)
                ->get();
        }
        return $this->getModelFrom($request)->count();
    }

    public function getModelFrom(Request $request) {
        return $this->getModel(
            $request->has('field') ? $request->input('field') : [],
            $request->has('op') ? $request->input('op') : [],
            $request->has('term') ? $request->input('term') : [],
            $request->has('order_by_column') ? $request->input('order_by_column') : [],
            $request->has('order_by_type') ? $request->input('order_by_type') : [],
            $request->has('with') ? $request->input('with') : []
        );
    }

    public function getModel($fields = [], $ops = [], $terms = [], $orderByColumns = [], $orderByTypes = [], $with = []) {
        $model = $this->assignedModel();

        $model = $this->applyOrderBy($model, $orderByColumns, $orderByTypes);
        $this->applyFilters($model, $fields, $ops, $terms);
        $this->applyWith($model, $with);

        return $model;
    }

    abstract function assignedModel();

    protected function applyFilters($model, $fields, $ops, $terms) {
        $filters = [];
        $termsIndex = -1;

        foreach($ops as $opIndex => $op) {

            /** If there is an operation with 2 parts, increase the terms index.
             *
             * If there is an operation with only one part ("col_a" is_null), the terms index remains the same.
             **/
            if($op !== 'is_null' && $op !== 'is_not_null') {
                $termsIndex += 1;

                if (array_key_exists($termsIndex, $terms)) {
                    if($op === 'like') {

                        $term = '%' . mb_strtolower($terms[$termsIndex]) . '%';
                    } else {

                        $term = mb_strtolower($terms[$termsIndex]);
                    }
                } else {
                    break;
                }
            } else {
                $term = null;
            }

            if(array_key_exists($opIndex, $fields)) {

                $filters []= $this->getFilters(mb_strtolower($fields[$opIndex]), $op, $term);
            }
        }

        return empty(array_diff($filters, [])) ? $model : $model->where($filters);
    }

    protected function applyWith($model, $with) {
        if(is_array($with)) {
            foreach($with as $related) {
                $this->applySingleWith($model, $related);
            }
        } else {
            $this->applySingleWith($model, $with);
        }

        return $model;
    }

    protected function applySingleWith($model, $related) {
        $model->with($related);
    }

    protected function applyOrderBy($model, $orderByColumns, $orderByTypes){
        if(!is_array($orderByColumns) || empty($orderByColumns)) {
            return $this->applySingleOrderBy($model, 'created_at', 'desc');
        }

        if(!is_array($orderByTypes)) {
            $orderByTypes = [];
        }

        foreach ($orderByColumns as $key => $column) {
            $model = $this->applySingleOrderBy($model, $column, isset($orderByTypes[$key]) ? $orderByTypes[$key] : 'desc');
        }

        return $model;
    }

    protected function applySingleOrderBy($model, $orderByColumn, $orderByType){
        return $model->orderBy($orderByColumn, $orderByType);
    }

    private function getFilters($field, $op, $term) {
        return array_key_exists($op, config('filterOperations')) ? [
            $field,
            config('filterOperations.' . $op),
            $term
        ] : null;
    }
}