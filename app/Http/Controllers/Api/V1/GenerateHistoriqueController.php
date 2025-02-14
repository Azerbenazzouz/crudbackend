<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\GenerateHistorique\DeleteMultipleRequest;
use App\Http\Requests\GenerateHistorique\DeleteRequest;
use App\Http\Requests\GenerateHistorique\StoreRequest;
use App\Http\Requests\GenerateHistorique\UpdateRequest;
use App\Http\Resources\GenerateHistoriqueResource;
use App\Service\Interfaces\GenerateHistoriqueServiceInterface;


class GenerateHistoriqueController extends BaseController
{
    protected $service;
    protected $resource = GenerateHistoriqueResource::class;

    public function __construct(
        GenerateHistoriqueServiceInterface $generateHistoriqueService
    ) {
        $this->service = $generateHistoriqueService;
    }


    protected function getStoreRequest(): string {
        return StoreRequest::class;
    }


    protected function getUpdateRequest(): string {
        return UpdateRequest::class;
    }


    protected function getDeleteRequest(): string {
        return DeleteRequest::class;
    }


    protected function getDeleteMultipleRequest(): string {
        return DeleteMultipleRequest::class;
    }

}
