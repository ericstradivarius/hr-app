<?php

namespace App\Optymous\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller {

    public function show($entity, $path) {
        return response()->download(storage_path('app/storage/uploads/' . $entity . '/document/' . $path));
    }
}
