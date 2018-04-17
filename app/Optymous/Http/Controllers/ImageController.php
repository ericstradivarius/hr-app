<?php

namespace App\Optymous\Http\Controllers;

use App\Optymous\Http\Transformers\Core\Manager;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

/**
 * @resource Image
 *
 */
class ImageController extends ApiController {
    private $filesystem;

    public function __construct(Manager $fractalManager, Filesystem $filesystem) {
        parent::__construct($fractalManager);

        $this->filesystem = $filesystem;
    }

    /**
     * Image Show
     *
     * Display the specified resource.
     *
     * @param $entity
     * @param $path
     * @return \Illuminate\Http\Response
     */
    public function show($entity, $path) {
        $fullPath = 'storage/uploads/' . $entity . '/image/' . $path;

        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $this->filesystem->getDriver(),
            'cache' => $this->filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'image',
        ]);

        return $server->getImageResponse($fullPath, request()->all());
    }
}
