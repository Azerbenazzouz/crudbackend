<?php

namespace App\Http\Requests\GenerateHistorique;

use App\Http\Requests\BaseRequest;
use App\Repositories\GenerateHistoriqueRepository;

class DeleteMultipleRequest extends BaseRequest
{
    private $GenerateHistoriqueRepository;

    public function __construct() {
        $this->GenerateHistoriqueRepository = app(GenerateHistoriqueRepository::class);
    }

    public function authorize(): bool {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => 'required|array',
        ];
    }


    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $ids = $this->input('ids');
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    if (!is_numeric($id)) {
                        $validator->errors()->add('generate_historique', 'Generate Historique id must be numeric');
                    }
                    $GenerateHistorique = $this->GenerateHistoriqueRepository->findById($id);
                    if (!$GenerateHistorique) {
                        $validator->errors()->add('generate_historique', 'Generate Historique not found with id: '.$id);
                    }
                }
            }
        });
    }
}
