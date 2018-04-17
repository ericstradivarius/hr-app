<?php namespace App\Optymous\Repositories;

use App\Optymous\campaign;

class campaignRepository extends Repository {
    function assignedModel() {
        return app(campaign::class);
    }
}