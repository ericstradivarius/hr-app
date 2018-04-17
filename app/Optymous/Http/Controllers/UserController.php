<?php

namespace App\Optymous\Http\Controllers;

use App\Optymous\Http\Requests\User\CountUserRequest;
use App\Optymous\Http\Requests\User\ExportUserRequest;
use App\Optymous\Http\Requests\User\IndexUserRequest;
use App\Optymous\Http\Requests\User\StoreUserRequest;
use App\Optymous\Http\Requests\User\UpdateUserRequest;
use App\Optymous\User;
use App\Optymous\Http\Transformers\Core\Manager;
use App\Optymous\Http\Transformers\UserTransformer;
use App\Optymous\Repositories\UserRepository;
use App\Optymous\Http\Transformers\Special\CountTransformer;
use Illuminate\Support\Facades\Auth;

/**
 * @resource User
 *
 */
class UserController extends ApiController {

    private $transformer;

    public function __construct(Manager $fractalManager, UserTransformer $transformer) {
        parent::__construct($fractalManager);

        $this->transformer = $transformer;
    }

    /**
     * User List
     *
     * Display a listing of the resource.
     *
     * @param IndexUserRequest $request
     * @param UserRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUserRequest $request, UserRepository $repository) {

        if($request->has('per_page')){

            return $this->collection($repository->getPerPageFrom($request), $this->transformer);
        }
        return $this->collection($repository->getModelFrom($request)->get(), $this->transformer);
    }

    /**
     * User Count
     *
     * Display the count of resource.
     *
     * @param CountUserRequest $request
     * @param CountTransformer $transformer
     * @param UserRepository $repository
     * @param User $model
     * @return \Illuminate\Http\Response
     */
    public function count(CountUserRequest $request, CountTransformer $transformer, UserRepository $repository, User $model) {

        return $this->getEntityCount($request, $model, $repository, $transformer);
    }

    /**
     * User Export
     *
     * Exports a listing of the resource.
     *
     * Export status == null if the handle was successful
     *
     * @param ExportUserRequest $request
     * @param UserRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function export(ExportUserRequest $request, UserRepository $repository) {

        return $this->handleExport($request, $repository);
    }

    /**
     * User Create
     *
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request) {
		$data = $request->only([
			"name",
			"email",
		]);

		if($request->has('password')) {
		    $data['password'] = bcrypt($request->input('password'));
        }
        $user = User::create($data);

        if($request->has("images")) {
            $user->files()->sync($request->input("images"));
        }

        return $this->item($user, $this->transformer);
    }

    /**
     * User Show
     *
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        $this->authorize('read', $user);
        return $this->item($user, $this->transformer);
    }

    /**
     * User Update
     *
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user) {
		if($request->has("name")) {
			$user->name = $request->input("name");
		}

		if($request->has("email")) {
			$user->email = $request->input("email");
		}

        if($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        if($request->has("images")) {
            $user->files()->sync($request->input("images"));
        }

        return $this->item($user, $this->transformer);
    }

    /**
     * User Delete
     *
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $this->authorize('delete', $user);
        $user->delete();

        return $this->item($user, $this->transformer);
    }

    public function me() {
        return $this->item(Auth::user(), $this->transformer);
    }
}
