<?php
namespace App\Service\Impl;

use App\Repositories\GenerateHistoriqueRepository;
use App\Service\Interfaces\GenerateHistoriqueServiceInterface;
use Illuminate\Http\Request;

class GenerateHistoriqueService extends BaseService implements GenerateHistoriqueServiceInterface{
    protected $generateHistoriqueRepo;
    protected $payload;

    public function __construct(
        GenerateHistoriqueRepository $generateHistoriqueRepo
    ) {
        parent::__construct($generateHistoriqueRepo);
        $this->generateHistoriqueRepo = $generateHistoriqueRepo;
    }

    protected function requestPayload(): array {
        return [];
    }

    protected function getSearchField(): array {
        return [];
    }

    protected function getPerpage() : int {
        return 20;
    }

    protected function getSimpleFilter() : array {
        return [];
    }

    protected function getComplexFilter(): array{
        return ['id'];
    }

    protected function getDateFilter(): array {
        return ['created_at'];
    }

    protected function processPayload(?Request $request = null) {
        $this->payload = $this->setUserId();
        return $this->payload;
    }
}
