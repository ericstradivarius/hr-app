<?php namespace App\Optymous\Repositories;

use App\Optymous\candidate;

class candidateRepository extends Repository {
    function assignedModel() {
        return app(candidate::class);
    }
}