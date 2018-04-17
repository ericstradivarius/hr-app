<?php

namespace App\Optymous\Http\Controllers;

use App\Optymous\Http\Requests\UserType\CountUserTypeRequest;
use App\Optymous\Http\Requests\UserType\ExportUserTypeRequest;
use App\Optymous\Http\Requests\UserType\IndexUserTypeRequest;
use App\Optymous\Http\Requests\UserType\StoreUserTypeRequest;
use App\Optymous\Http\Requests\UserType\UpdateUserTypeRequest;
use App\Optymous\UserType;
use App\Optymous\Http\Transformers\Core\Manager;
use App\Optymous\Http\Transformers\UserTypeTransformer;
use App\Optymous\Repositories\UserTypeRepository;
use App\Optymous\Http\Transformers\Special\CountTransformer;
use Illuminate\Support\Facades\Auth;

/**
 * @resource UserType
 *
 */
class UserTypeController extends ApiController {

    private $transformer;

    public function __construct(Manager $fractalManager, UserTypeTransformer $transformer) {
        parent::__construct($fractalManager);

        $this->transformer = $transformer;
    }

    /**
     * UserType List
     *
     * Display a listing of the resource.
     *
     * @param IndexUserTypeRequest $request
     * @param UserTypeRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUserTypeRequest $request, UserTypeRepository $repository) {

        if($request->has('per_page')){

            return $this->collection($repository->getPerPageFrom($request), $this->transformer);
        }
        return $this->collection($repository->getModelFrom($request)->get(), $this->transformer);
    }

    /**
     * UserType Count
     *
     * Display the count of resource.
     *
     * @param CountUserTypeRequest $request
     * @param CountTransformer $transformer
     * @param UserTypeRepository $repository
     * @param UserType $model
     * @return \Illuminate\Http\Response
     */
    public function count(CountUserTypeRequest $request, CountTransformer $transformer, UserTypeRepository $repository, UserType $model) {

        return $this->getEntityCount($request, $model, $repository, $transformer);
    }

    /**
     * UserType Export
     *
     * Exports a listing of the resource.
     *
     * Export status == null if the handle was successful
     *
     * @param ExportUserTypeRequest $request
     * @param UserTypeRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function export(ExportUserTypeRequest $request, UserTypeRepository $repository) {

        return $this->handleExport($request, $repository);
    }

    /**
     * UserType Create
     *
     * Store a newly created resource in storage.
     *
     * @param  StoreUserTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserTypeRequest $request) {
		$data = $request->only([
			"name",
		]);
        $userType = UserType::create($data);


        return $this->item($userType, $this->transformer);
    }

    /**
     * UserType Show
     *
     * Display the specified resource.
     *
     * @param UserType $userType
     * @return \Illuminate\Http\Response
     */
    public function show(UserType $userType) {
        $this->authorize('read', $userType);
        return $this->item($userType, $this->transformer);
    }

    /**
     * UserType Update
     *
     * Update the specified resource in storage.
     *
     * @param  UpdateUserTypeRequest $request
     * @param UserType $userType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserTypeRequest $request, UserType $userType) {
		if($request->has("name")) {
			$userType->name = $request->input("name");
		}

        $userType->save();


        return $this->item($userType, $this->transformer);
    }

    /**
     * UserType Delete
     *
     * Remove the specified resource from storage.
     *
     * @param UserType $userType
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserType $userType) {
        $this->authorize('delete', $userType);
        $userType->delete();

        return $this->item($userType, $this->transformer);
    }
}
