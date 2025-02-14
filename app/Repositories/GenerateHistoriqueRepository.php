<?php
namespace App\Repositories;

use App\Models\GenerateHistorique;

class GenerateHistoriqueRepository extends BaseRepositroy {
    public function __construct(GenerateHistorique $model) {
        parent::__construct($model);
    }
}
