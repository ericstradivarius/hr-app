<?php namespace App\Optymous\Http\Controllers;

use App\Optymous\Exporters\Core\ExporterFactory;
use App\Optymous\Http\Transformers\Core\Manager;
use App\Optymous\Http\Transformers\Special\UrlTransformer;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends Controller {
    protected $fractalManager;

    public function __construct(Manager $fractalManager) {
        $this->fractalManager = $fractalManager;
    }

    public function collection($data, TransformerAbstract $transformer) {
        if(is_object($data) && $data instanceof LengthAwarePaginator) {
            return $this->pagedCollection($data, [
                'current' => $data->currentPage(),
                'totalItems' => $data->total(),
                'pagination' => [
                    'size' => 3
                ],
                'limit' => request('limit')
            ], $transformer);
        }

        return $this->fractalManager->respondCollection($data, $transformer, Response::HTTP_OK);
    }

    public function pagedCollection($data, $pager, TransformerAbstract $transformer) {
        return $this->fractalManager->respondPagedCollection($data, $pager, $transformer, Response::HTTP_OK);
    }

    public function item($data, TransformerAbstract $transformer) {
        if(!$data) {
            throw new NotFoundHttpException('Entity not found');
        }

        return $this->fractalManager->respondItem($data, $transformer, Response::HTTP_OK);
    }

    public function rawErrors($errors, $code) {
        return response()->json([
            "errors" => $errors,
            "data" => null,
            "status" => $code,
            "statusText" => Response::$statusTexts[$code]
        ], $code);
    }

    public function error($errorMessage) {
        return $this->rawErrors([
            "general" => [
                $errorMessage
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function unauthorized($errorMessage) {
        return $this->rawErrors([
            "general" => [
                $errorMessage
            ]
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function handleExport($request, $repository) {
        $exporterFactory = app(ExporterFactory::class);
        $urlTransformer = new UrlTransformer();

        $model = $repository->getModelFrom($request);
        $exportStatus = $exporterFactory->handle($request, $model);

        if(isset($exportStatus['error'])) {
            return $this->error($exportStatus['error']);
        }
        return $this->item($exportStatus, $urlTransformer);
    }

    protected function getEntityCount($request, $model, $repository, $transformer) {
        if($request->has('field')) {
            $field = $request->input('field');
            return $this->checkColumn($request, $model, $repository, $transformer, $field);
        }
        return $this->item(['value' => 'all', 'count' => $repository->getCountFrom($request)], $transformer);
    }

    private function checkColumn($request, $model, $repository, $transformer, $field) {
        if(Schema::hasColumn($model->getTable(), $field)) {
            return $this->getCount($request, $model, $repository, $transformer, $field);
        }
        return $this->error("Requested group by option does not exist");
    }

    private function getCount($request, $model, $repository, $transformer, $field) {
        $columnType = Schema::getColumnType($model->getTable(), $field);

        if($columnType === 'datetime' || $columnType === 'date' && $request->has('granularity')) {
            $granularity = $request->input('granularity');

            $typeOfGranularity = [
                'year' => '%Y',
                'month' => '%Y-%m',
                'day' => '%Y-%m-%d',
                'hour' => '%Y-%m-%d %H',
                'minute' => '%Y-%m-%d %H:%i'
            ];
            if(array_key_exists(strtolower($granularity),$typeOfGranularity)) {
                return $this->collection($repository->getCountFrom($request, $field, $typeOfGranularity[$granularity]), $transformer);
            }
            return $this->error("Requested granularity group by option does not exist");
        }
        return $this->collection($repository->getCountFrom($request, $field), $transformer);
    }
}