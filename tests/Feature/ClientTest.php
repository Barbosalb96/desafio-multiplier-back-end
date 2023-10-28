<?php

namespace Tests\Feature;

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
        $clints = $this->generateClients();

        $response = $this->actingAs($user)
            ->postJson('api/client', $clints);

        $response->assertStatus(200);
    }

    /**
     * test_create_client_fail_no_auth
     */
    public function test_create_client_fail_no_auth(): void
    {
        $clints = $this->generateClients();
        $response = $this->postJson('api/client', $clints);
        $response->assertStatus(401);
        $response->assertJson(fn(AssertableJson $json) => $json->has('message'));
    }

    /**
     * test_create_client_fail_params_invalid
     */
    public function test_create_client_fail_params_invalid(): void
    {
        $user = User::factory(1)->create()->first();
        $clints = $this->generateClients();
        $clints['cnpj'] = '123456789123';

        $response = $this->actingAs($user)
            ->postJson('api/client', $clints);

        $response->assertBadRequest();
        $response->assertJson(fn(AssertableJson $json) => $json->where('message', 'O CNPJ não é válido.'));
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
