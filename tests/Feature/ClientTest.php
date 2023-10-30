<?php

namespace Tests\Feature;

use App\Domain\Client\Entities\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test_create_client_success
     */
    public function test_create_client_success(): void
    {
        $user = User::factory(1)->create()->first();
        $clients = $this->generateClients();

        $response = $this->actingAs($user)
            ->postJson('api/client', $clients);

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->where('data.message', trans('message.created_success')));
    }

    /**
     * test_create_client_fail_no_auth
     */
    public function test_create_client_fail_no_auth(): void
    {
        $clients = $this->generateClients();
        $response = $this->postJson('api/client', $clients);
        $response->assertStatus(401);
        $response->assertJson(fn(AssertableJson $json) => $json->has('message'));
    }

    /**
     * test_create_client_fail_params_invalid
     */
    public function test_create_client_fail_params_invalid(): void
    {
        $user = User::factory(1)->create()->first();
        $clients = $this->generateClients();
        $clients['cnpj'] = '123456789123';

        $response = $this->actingAs($user)
            ->postJson('api/client', $clients);

        $response->assertBadRequest();
        $response->assertJson(fn(AssertableJson $json) => $json->where('message', 'O CNPJ não é válido.'));
    }

    /**
     * test_create_client_fail_params_invalid
     */
    public function test_update_client(): void
    {
        $user = $this->storeClient();
        $client = Client::first();
        $clients = $this->generateClients();
        $clients['id_public'] = $client->id_public;
        $clients['nome_fantasia'] = 'Update Client';

        $response = $this->actingAs($user)
            ->putJson('api/client', $clients);
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->where('data.message', trans('message.update_success')));
    }

    /**
     * test_get_client
     */
    public function test_get_client(): void
    {
        $user = $this->storeClient();

        $response = $this->actingAs($user)
            ->get('api/client');

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->hasAny(['data', 'links', 'meta']));
    }

    /**
     * test_get_client
     */
    public function test_find_client(): void
    {
        $user = $this->storeClient();

        $client = Client::first();

        $response = $this->actingAs($user)
            ->get('api/client/' . $client->id_public);

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('data.id_public', $client->id_public)
            ->where('data.nome_fantasia', $client->nome_fantasia)
            ->where('data.email', $client->email)
            ->where('data.cnpj', $client->cnpj)
            ->where('data.endereco', $client->endereco)
            ->where('data.cidade', $client->cidade)
            ->where('data.estado', $client->estado)
            ->where('data.pais', $client->pais)
            ->where('data.telefone', $client->telefone)
        );
    }


    /**
     * test_delete_client
     */
    public function test_delete_client(): void
    {
        $user = $this->storeClient();
        $client = Client::first();

        $response = $this->actingAs($user)
            ->delete('api/client/' . $client->id_public);

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->where('data.message', trans('message.delete_success')));
    }


    private function storeClient()
    {
        $user = User::factory(1)->create()->first();

        $clients = $this->generateClients();

        $this->actingAs($user)
            ->postJson('api/client', $clients);

        return $user;

    }

    /**
     * Generate clients
     */
    private function generateClients(): array
    {
        $cnpjValidos = [
            "00.000.000/0001-91",
            "03.995.515/0013-09",
            '47.960.950/0001-21'
        ];
        return [
            'cnpj' => collect($cnpjValidos)->random(),
            'nome_fantasia' => $this->faker->text(20),
            'email' => $this->faker->unique()->email,
            'endereco' => $this->faker->address,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->state,
            'pais' => $this->faker->country,
            'telefone' => $this->faker->randomNumber(9),
            'area_atuacao_cnae' => $this->faker->text(20),
            "qsa" => [
                [
                    "nome" => $this->faker->name(),
                    "qualificacao" => $this->faker->text(),
                ],
                [
                    "nome" => $this->faker->name(),
                    "qualificacao" => $this->faker->text(),
                ]
            ]
        ];
    }
}
