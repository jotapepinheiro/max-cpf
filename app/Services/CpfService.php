<?php

namespace App\Services;

use App\Exceptions\MsgExeptions;
use App\Http\Resources\CpfResource;
use App\Repositories\CpfRepository;
use App\Exceptions\ServiceException;
use Illuminate\Http\JsonResponse;
use Respect\Validation\Validator as v;

class CpfService
{
    /**
     * @var cpfRepository
     */
    private CpfRepository $cpfRepository;

    /**
     * @param $request
     * @return mixed
     */
    public function findAll($request = null)
    {
        if ($request->has('paged') && $request->boolean('paged')) {
            return $this->getCpfRepository()->findAllCpfWithUser()->response();
        } else {
            return $this->getCpfRepository()->findAllCpf()->response();
        }
    }

    /**
     * @param string $cpf
     * @return CpfResource
     * @throws ServiceException
     */
    public function checkCpf(string $cpf): CpfResource
    {
        $cpfValidator = v::cpf()->noWhitespace()->length(1, 11)->setName('CPF');

        try {
            $cpfValidator->check($cpf);
        }
        catch(\Exception $e)  {
            throw new ServiceException(MsgExeptions::CPF['INVALID']['MSG'], MsgExeptions::CPF['INVALID']['TYPE'], 422);
        }

        return $this->getCpfRepository()->checkCpf($cpf);
    }

    /**
     * @param $request
     * @return CpfResource
     * @throws ServiceException
     */
    public function addCpf($request): CpfResource
    {
        $input = $request->only('cpf', 'user_id');

        try {
            $cpf = $this->getCpfRepository()->create($input);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::CPF['CREATE']['MSG'], MsgExeptions::CPF['CREATE']['TYPE'], 422);
        }

        return new CpfResource($cpf);
    }

    /**
     * @param $cpf
     * @return JsonResponse
     * @throws ServiceException
     */
    public function removeCpf($cpf): JsonResponse
    {
        $idCpf = $this->checkCpf($cpf)->id;

        try {
            $this->getCpfRepository()->delete($idCpf);
        } catch (\Exception $e) {
            throw new ServiceException(MsgExeptions::CPF['REMOVE']['MSG'], MsgExeptions::CPF['CREATE']['TYPE'], 422);
        }

        return response()->json(['success' => true], 410);
    }

    /**
     * @return CpfRepository|mixed
     */
    private function getCpfRepository(): CpfRepository
    {
        if (empty($this->cpfRepository)) {
            $this->cpfRepository = new CpfRepository();
        }

        return $this->cpfRepository;
    }

}
