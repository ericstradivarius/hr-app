<?php namespace App\Optymous\Http\Transformers\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

class Manager {
    protected $fractal;

    public function __construct(FractalManager $fractal, Request $request) {
        $this->fractal = $fractal;
        $this->fractal->setSerializer(new Serializer);

        if($request->has('with')) {
            $this->fractal->parseIncludes($request->input('with'));
        }
    }

    public function transform(ResourceAbstract $resource) {
        return $this->fractal->createData($resource)->toArray();
    }

    public function rawRespond($data, $returnCode) {
        return response()->json([
            "errors" => null,
            "data" => $data,
            "status" => $returnCode,
            "statusText" => Response::$statusTexts[$returnCode]
        ], $returnCode);
    }

    public function respond(ResourceAbstract $resource, $returnCode) {
        return $this->rawRespond($this->transform($resource), $returnCode);
    }

    public function respondPager(ResourceAbstract $resource, $pager, $returnCode) {
        return $this->rawRespond([
            'data' => $this->transform($resource),
            'pager' => $pager
        ], $returnCode);
    }

    public function respondPagedCollection($data, $pager, TransformerAbstract $transformer, $returnCode) {
        return $this->respondPager(new Collection($data, $transformer), $pager, $returnCode);
    }

    public function respondCollection($data, TransformerAbstract $transformer, $returnCode) {
        return $this->respond(new Collection($data, $transformer), $returnCode);
    }

    public function respondItem($data, TransformerAbstract $transformer, $returnCode) {
        return $this->respond(new Item($data, $transformer), $returnCode);
    }
}