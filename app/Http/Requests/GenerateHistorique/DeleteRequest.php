<?php

namespace App\Http\Requests\GenerateHistorique;

use App\Http\Requests\BaseRequest;
use App\Repositories\GenerateHistoriqueRepository;

class DeleteRequest extends BaseRequest {

    private $GenerateHistoriqueRepository;

    public function __construct() {
        $this->GenerateHistoriqueRepository = app(GenerateHistoriqueRepository::class);
    }

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $generate_historique = $this->GenerateHistoriqueRepository->findById($this->route('generate_historique'));
            if (!$generate_historique) {
                $validator->errors()->add('generate_historique', 'Generate Historique not found');
            }
        });
    }
}
