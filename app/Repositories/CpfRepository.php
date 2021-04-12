<?php

namespace App\Repositories;

use Exception;
use App\Models\Cpf;
use App\Exceptions\MsgExeptions;
use App\Http\Resources\CpfResource;
use App\Exceptions\ServiceException;
use App\Http\Resources\CpfCollection;

class CpfRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected array $fieldSearchable = [
        'cpf'
    ];

    /**
     * @return string[]
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * @return string
     */
    public function model(): string
    {
        return Cpf::class;
    }

    /**
     * @return CpfCollection
     */
    public function findAllCpfWithUser(): CpfCollection
    {
        $cpfs = Cpf::with(['user']);

        return new CpfCollection($cpfs->paginate(10));
    }

    /**
     * @return CpfCollection
     */
    public function findAllCpf(): CpfCollection
    {
        $cpfs = Cpf::with(['user']);

        return new CpfCollection($cpfs->get());
    }

    /**
     * @param string $cpf
     * @return CpfResource
     * @throws ServiceException
     */
    public function checkCpf(string $cpf): CpfResource
    {
        try {
            $cpfs = Cpf::where('cpf', $cpf)->firstOrFail();
        } catch (Exception $e) {
            throw new ServiceException(MsgExeptions::CPF['NOT_FOUND']['MSG'], MsgExeptions::CPF['NOT_FOUND']['TYPE'], 404);
        }

        return new CpfResource($cpfs);
    }
}
