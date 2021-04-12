<?php

namespace Tests\Unit;

use App\Models\Cpf;
use App\Models\User;
use Tests\TestCase;

class CpfTest extends TestCase
{
    /**
     * @var User|null
     */
    private ?User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::withRole('admin')->first();
    }

    /**
     * Testar página home
     *
     * @return void
     */
    public function testHome()
    {
        $this->get('/');

        $this->seeStatusCode(200);
    }

    /**
     * /cpf [GET]
     */
    public function testShowAllCpfs()
    {
        $this->be($this->user);

        $this->get("api/v1/cpf/", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'Content' => ['*' =>
                [
                    'cpf',
                    'createdAt'
                ]
            ]
        ]);
    }

    /**
     * /cpf [GET]
     */
    public function testShowAllCpfsPaginate()
    {
        $this->be($this->user);

        $this->get("api/v1/cpf/?paged=true", []);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                'Content' => [
                    '*' => [
                        'cpf',
                        'createdAt'
                    ]
                ]
            ]
        ]);
    }

    /**
     * /cpf [POST]
     */
    public function testCreateCpf()
    {
        $this->be($this->user);

        $cpf = Cpf::factory()->make()->toArray();

        $data = array_merge($cpf, ['user_id' => $this->user->id]);

        $this->post('api/v1/cpf', $data);

        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['Content' =>
                [
                    'cpf',
                    'createdAt'
                ]
            ]
        );
    }

    /**
     * /cpf/cpf [GET]
     */
    public function testCheckCpf()
    {
        $this->be($this->user);

        $data = Cpf::inRandomOrder()->first();

        $this->get('api/v1/cpf/'.$data->cpf);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['Content' =>
                [
                    'cpf',
                    'createdAt'
                ]
            ]
        );
    }

    /**
     * /cpf/cpf [DELETE]
     */
    public function testDeleteCpf()
    {
        $this->be($this->user);

        $data = Cpf::all()->last();

        $this->delete("api/v1/cpf/".$data->cpf, [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'success'
        ]);
    }
}
