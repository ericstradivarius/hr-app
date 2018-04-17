<?php

namespace App\Optymous\Http\Controllers;

use App\Optymous\Http\Requests\campaign\CountcampaignRequest;
use App\Optymous\Http\Requests\campaign\ExportcampaignRequest;
use App\Optymous\Http\Requests\campaign\IndexcampaignRequest;
use App\Optymous\Http\Requests\campaign\StorecampaignRequest;
use App\Optymous\Http\Requests\campaign\UpdatecampaignRequest;
use App\Optymous\campaign;
use App\Optymous\Http\Transformers\Core\Manager;
use App\Optymous\Http\Transformers\campaignTransformer;
use App\Optymous\Repositories\campaignRepository;
use App\Optymous\Http\Transformers\Special\CountTransformer;
use Illuminate\Support\Facades\Auth;

/**
 * @resource campaign
 *
 */
class campaignController extends ApiController {

    private $transformer;

    public function __construct(Manager $fractalManager, campaignTransformer $transformer) {
        parent::__construct($fractalManager);

        $this->transformer = $transformer;
    }

    /**
     * campaign List
     *
     * Display a listing of the resource.
     *
     * @param IndexcampaignRequest $request
     * @param campaignRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function index(IndexcampaignRequest $request, campaignRepository $repository) {

        if($request->has('per_page')){

            return $this->collection($repository->getPerPageFrom($request), $this->transformer);
        }
        return $this->collection($repository->getModelFrom($request)->get(), $this->transformer);
    }

    /**
     * campaign Count
     *
     * Display the count of resource.
     *
     * @param CountcampaignRequest $request
     * @param CountTransformer $transformer
     * @param campaignRepository $repository
     * @param campaign $model
     * @return \Illuminate\Http\Response
     */
    public function count(CountcampaignRequest $request, CountTransformer $transformer, campaignRepository $repository, campaign $model) {

        return $this->getEntityCount($request, $model, $repository, $transformer);
    }

    /**
     * campaign Export
     *
     * Exports a listing of the resource.
     *
     * Export status == null if the handle was successful
     *
     * @param ExportcampaignRequest $request
     * @param campaignRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function export(ExportcampaignRequest $request, campaignRepository $repository) {

        return $this->handleExport($request, $repository);
    }

    /**
     * campaign Create
     *
     * Store a newly created resource in storage.
     *
     * @param  StorecampaignRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecampaignRequest $request) {
		$data = $request->only([
			"name",
			"start_date",
			"end_date",
			"status",
			"available_jobs",
			"description",
		]);
        $campaign = campaign::create($data);
        if($request->has("candidates")) {
            $campaign->candidates()->sync($request->input("candidates"));
        }

        if($request->has("files")) {
            $campaign->files()->sync($request->input("files"));
        }


        return $this->item($campaign, $this->transformer);
    }

    /**
     * campaign Show
     *
     * Display the specified resource.
     *
     * @param campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(campaign $campaign) {
        $this->authorize('read', $campaign);
        return $this->item($campaign, $this->transformer);
    }

    /**
     * campaign Update
     *
     * Update the specified resource in storage.
     *
     * @param  UpdatecampaignRequest $request
     * @param campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecampaignRequest $request, campaign $campaign) {
		if($request->has("name")) {
			$campaign->name = $request->input("name");
		}

		if($request->has("start_date")) {
			$campaign->start_date = $request->input("start_date");
		}

		if($request->has("end_date")) {
			$campaign->end_date = $request->input("end_date");
		}

		if($request->has("status")) {
			$campaign->status = $request->input("status");
		}

		if($request->has("available_jobs")) {
			$campaign->available_jobs = $request->input("available_jobs");
		}

		if($request->has("description")) {
			$campaign->description = $request->input("description");
		}

        $campaign->save();

        if($request->has("candidates")) {
            $campaign->candidates()->sync($request->input("candidates"));
        }

        if($request->has("files")) {
            $campaign->files()->sync($request->input("files"));
        }


        return $this->item($campaign, $this->transformer);
    }

    /**
     * campaign Delete
     *
     * Remove the specified resource from storage.
     *
     * @param campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(campaign $campaign) {
        $this->authorize('delete', $campaign);
        $campaign->delete();

        return $this->item($campaign, $this->transformer);
    }
}
