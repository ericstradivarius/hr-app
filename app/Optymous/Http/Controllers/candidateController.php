<?php

namespace App\Optymous\Http\Controllers;

use App\Optymous\campaign;
use App\Optymous\Http\Requests\candidate\CountcandidateRequest;
use App\Optymous\Http\Requests\candidate\ExportcandidateRequest;
use App\Optymous\Http\Requests\candidate\IndexcandidateRequest;
use App\Optymous\Http\Requests\candidate\StorecandidateRequest;
use App\Optymous\Http\Requests\candidate\UpdatecandidateRequest;
use App\Optymous\candidate;
use App\Optymous\Http\Transformers\Core\Manager;
use App\Optymous\Http\Transformers\candidateTransformer;
use App\Optymous\Repositories\candidateRepository;
use App\Optymous\Http\Transformers\Special\CountTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @resource candidate
 *
 */
class candidateController extends ApiController {

    private $transformer;

    public function __construct(Manager $fractalManager, candidateTransformer $transformer) {
        parent::__construct($fractalManager);

        $this->transformer = $transformer;
    }

    /**
     * candidate List
     *
     * Display a listing of the resource.
     *
     * @param IndexcandidateRequest $request
     * @param candidateRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function index(IndexcandidateRequest $request, candidateRepository $repository) {
        if($request->has('per_page')){

            return $this->collection($repository->getPerPageFrom($request), $this->transformer);
        }
        return $this->collection($repository->getModelFrom($request)->get(), $this->transformer);
    }

    public function campaignCandidates(Request $request) {
        if($request->has('id')) {
            $candidateIds = DB::table('campaign_candidates_pivot')->where('campaign_id', $request->input('id'))->pluck('candidate_id')->toArray();
            if ($request->has('per_page')) {
                return $this->collection(Candidate::whereIn('id', $candidateIds)->paginate($request->input('per_page')), $this->transformer);
            }
            return $this->collection(Candidate::whereIn('id', $candidateIds)->get(), $this->transformer);
        }
    }

    /**
     * candidate Count
     *
     * Display the count of resource.
     *
     * @param CountcandidateRequest $request
     * @param CountTransformer $transformer
     * @param candidateRepository $repository
     * @param candidate $model
     * @return \Illuminate\Http\Response
     */
    public function count(CountcandidateRequest $request, CountTransformer $transformer, candidateRepository $repository, candidate $model) {

        return $this->getEntityCount($request, $model, $repository, $transformer);
    }

    /**
     * candidate Export
     *
     * Exports a listing of the resource.
     *
     * Export status == null if the handle was successful
     *
     * @param ExportcandidateRequest $request
     * @param candidateRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function export(ExportcandidateRequest $request, candidateRepository $repository) {

        return $this->handleExport($request, $repository);
    }

    /**
     * candidate Create
     *
     * Store a newly created resource in storage.
     *
     * @param  StorecandidateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecandidateRequest $request) {
		$data = $request->only([
			"first_name",
			"last_name",
			"email",
			"phone",
			"status",
			"dob",
            "stage"
		]);
        $candidate = candidate::create($data);
        if($request->has("campaigns")) {
            $candidate->campaigns()->sync($request->input("campaigns"));
        }

        if($request->has("cv")) {
            $candidate->files()->sync($request->input("cv"));
        }

        foreach ($candidate->campaigns as $campaign) {
            $campaign = campaign::where('id', $campaign->id)->first();
            $campaign->candidates_total = count($campaign->candidates);
            $campaign->save();
        }

        $candidate->campaigns_total = count($candidate->campaigns);
        $candidate->save();


        return $this->item($candidate, $this->transformer);
    }

    /**
     * candidate Show
     *
     * Display the specified resource.
     *
     * @param candidate $candidate
     * @return \Illuminate\Http\Response
     */
    public function show(candidate $candidate) {
        $this->authorize('read', $candidate);
        return $this->item($candidate, $this->transformer);
    }

    /**
     * candidate Update
     *
     * Update the specified resource in storage.
     *
     * @param  UpdatecandidateRequest $request
     * @param candidate $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecandidateRequest $request, candidate $candidate) {
		if($request->has("first_name")) {
			$candidate->first_name = $request->input("first_name");
		}

		if($request->has("last_name")) {
			$candidate->last_name = $request->input("last_name");
		}

		if($request->has("email")) {
			$candidate->email = $request->input("email");
		}

		if($request->has("phone")) {
			$candidate->phone = $request->input("phone");
		}

		if($request->has("status")) {
			$candidate->status = $request->input("status");
		}

		if($request->has("dob")) {
			$candidate->dob = $request->input("dob");
		}
        if($request->has("stage")) {
            $candidate->stage = $request->input("stage");
        }

        $candidate->save();

        if($request->has("campaigns")) {
            $candidate->campaigns()->sync($request->input("campaigns"));
        }

        if($request->has("cv")) {
            $candidate->files()->sync($request->input("cv"));
        }

        foreach ($candidate->campaigns as $campaign) {
            $campaign = campaign::where('id', $campaign->id)->first();
            $campaign->candidates_total = count($campaign->candidates);
            $campaign->save();
        }

        $candidate->campaigns_total = count($candidate->campaigns);
        $candidate->save();



        return $this->item($candidate, $this->transformer);
    }

    /**
     * candidate Delete
     *
     * Remove the specified resource from storage.
     *
     * @param candidate $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(candidate $candidate) {
        $this->authorize('delete', $candidate);
        foreach ($candidate->campaigns as $campaign) {
            $campaign = campaign::where('id', $campaign->id)->first();
            $count =  count($campaign->candidates);
            $count--;
            $campaign->candidates_total = $count;
            $campaign->save();
        }

        $candidate->delete();
        return $this->item($candidate, $this->transformer);
    }
}
