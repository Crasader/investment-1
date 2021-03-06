<?php

namespace App\Services;

use App\Repositories\InstitutionRepository;
use App\Validators\InstitutionValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Exceptions;

class InstitutionService
{
  private $repository;
  private $validator;

  public function __construct(InstitutionRepository $repository, InstitutionValidator $validator)
  {
    $this->repository = $repository;
    $this->validator = $validator;
  }

  public function store(array $data)
  {
    try {

      $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
      $institution = $this->repository->create($data);

      return[
        'success' => true,
        'message' => "Registered Institution!",
        'data' => $institution,
      ];

    } catch (Exception $e) {

      switch (get_class($e))
      {
        case QueryException::class      : return ['success' => false, 'message' => $e->getMessage()];
        case ValidatorException::class  : return ['success' => false, 'message' => $e->getMessageBag()];
        case Exception::class           : return ['success' => false, 'message' => $e->getMessage()];
        default                         : return ['success' => false, 'message' => $e->getMessage()];
      }
    }
  }

  public function update (array $data, $id)
  {
    try {

      $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
      $institution = $this->repository->update($data, $id);

      return[
        'success' => true,
        'message' => "Updated Institution!",
        'data' => $institution,
      ];

    } catch (Exception $e) {

      switch (get_class($e))
      {
        case QueryException::class      : return ['success' => false, 'message' => $e->getMessage()];
        case ValidatorException::class  : return ['success' => false, 'message' => $e->getMessageBag()];
        case Exception::class           : return ['success' => false, 'message' => $e->getMessage()];
        default                         : return ['success' => false, 'message' => $e->getMessage()];
      }
    }
  }
}
