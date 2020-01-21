<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use sysPluri\aluno;

class viewsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testSearchAluno()
    {
        $data = ['nome' => 'Francisco'];
        $aluno = new aluno();

        $response = $this->post('/aluno/buscar', $data);

        $response
            ->assertStatus(200);
            $response
            ->assertExactJson($aluno->searchAluno($data)->toArray());
    }

    public function testSaveAluno1(){
        $aluno = new aluno();
        $data = ['nome' => '', 'email' => 'abcde@gmail.com', 'data_nascimento' => '10/05/2000'];

        $response = $this->post('/aluno', $data);
        $response->assertJson(["status" => false]);
    }

    public function testSaveAluno2(){
        $aluno = new aluno();
        $data = ['nome' => 'asfhkajsdhfkjadsffasdkgfgjkgjksfgaksjgfkjsafgkjsadhkjasdhfkasjdfhlaksdjfhlkasjdfhlasdjfhlkjasdhflkasjdfhlksdjfhlksajdfhlkjsdfsakfgkjffjkgffffkjghdsfdghsfkjsfgkljshgfjkgwyetfewyguysghlksjdfhlksjdfhlsdjhflkjsdfhlkjsdfhlkjsdhfkljsdhlfaslkdhfaskljdhfklajsdfhlaskjdfhaksjdfhlkjsdfhlkjsdfhlsdjfhlksjdfhlksjh',
         'email' => 'abcde@gmail.com', 
         'data_nascimento' => '10/05/2000'];

        $response = $this->post('/aluno', $data);
        $response->assertJson(["status" => false]);
    }

    public function testSaveAluno3(){
        $aluno = new aluno();
        $data = ['nome' => 'Marcos André',
         'email' => 'marcosandre@gmail.com', 
         'data_nascimento' => '10/05/1965'];

        $response = $this->post('/aluno', $data);
        $response->assertJson(["status" => true]);
    }

    public function testSaveAluno4(){
        $aluno = new aluno();
        $data = ['nome' => 'Marcos André',
         'id'    => '1',
         'email' => 'marcosandre@gmail.com', 
         'data_nascimento' => '10/05/1965'];

        $response = $this->put('/aluno', $data);
        $response->assertJson(["status" => true]);
    }
}
