<?php

namespace sysPluri;

use Illuminate\Database\Eloquent\Model;

use sysPluri\config;

class aluno extends Model
{
    protected $table = "aluno";
    protected $fillable = ['nome', 'email', 'sexo', 'data_nascimento'];

    public function searchAll(){
        $alunos = aluno::all();
        return $alunos;
    }

    public function checkAluno($object){
        if (strlen($object["nome"]) <= 0 || strlen($object["nome"]) > 255) return ["mensagem" => "Nome de aluno inválido! Nome deve conter entre 0 e 255 caracteres", "status" => false];
        if (strlen($object["email"]) <= 0 || strlen($object["email"]) > 255 || !filter_var($object["email"], FILTER_VALIDATE_EMAIL)) return ["mensagem" => "Email de aluno inválido! Email deve ser válido e conter entre 0 e 255 caracteres", "status" => false];
        if (strlen($object["data_nascimento"]) <= 0 || strlen($object["data_nascimento"]) > 10 || !config::validarData($object["data_nascimento"])) return ["mensagem" => "Data de nascimento de aluno inválida!", "status" => false];
        
        return ["mensagem" => "", "status" => true];
    }

    public function saveOrUpdateAluno($object){
        if ($object->save()){
            return ["mensagem" => "Aluno {$object['nome']} salvo com sucesso!", "status" => true];
        }else{
            return ["mensagem" => "Não foi possível salvar o aluno {$object['nome']}!", "status" => false]; 
        }
    }

    public function saveAluno($object){
        $check = $this->checkAluno($object);
        if ($check["status"]){
            $newAluno = new aluno($object);
            $returns = $this->saveOrUpdateAluno($newAluno);
            return $returns;
        }else{
            return $check;
        }
    }

    public function editAluno($object){
        if (strlen($object["id"]) <= 0) return ["mensagem" => "Identificador do aluno não informado!", "status" => false];
        $check = $this->checkAluno($object);
        if ($check["status"]){
            $aluno = aluno::find($object["id"]);
            $aluno->nome  = $object["nome"];
            $aluno->email = $object["email"];
            $aluno->sexo  = isset($object["sexo"]) ? $object["sexo"] : $aluno->sexo;
            $aluno->data_nascimento = config::formataDataBase($object["data_nascimento"]);
            return $this->saveOrUpdateAluno($aluno);
        }else{
            return $check;
        }
    }

    public function deleteAluno($object){
        if (strlen($object["id"]) <= 0) return ["mensagem" => "Identificador do aluno não informado!", "status" => false];
        if (aluno::destroy($object["id"])){
            return ["mensagem" => "Aluno excluído com sucesso!", "status" => true];
        }else{
            return ["mensagem" => "Não foi possível excluir o aluno!", "status" => false];
        }
    }

}
