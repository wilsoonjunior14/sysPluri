<?php

namespace sysPluri;

use Illuminate\Database\Eloquent\Model;

class matricula extends Model
{
    protected $table = "matricula";
    protected $fillable = ['id_curso', 'id_aluno'];

    public function searchAll(){
        return $this->all();
    }

    public function check($object){
        if (!isset($object["id_curso"]) || empty($object["id_curso"])) return ["mensagem" => "Identificador do curso não informado!", "status" => false];
        if (!isset($object["id_aluno"]) || empty($object["id_aluno"])) return ["mensagem" => "Identificador do aluno não informado!", "status" => false];

        return ["mensagem" => "", "status" => true];
    }

    public function saveOrUpdateMatricula($object){
        if ($object->save()){
            return ["mensagem" => "Matrícula salva com sucesso!", "status" => true];
        }else{
            return ["mensagem" => "Não foi possível salvar a matrícula", "status" => false];
        }
    }

    public function saveMatricula($object){
        $check = $this->check($object);
        if ($check["status"]){
            $newMatricula = new matricula($object);
            return $this->saveOrUpdateMatricula($newMatricula);
        }else{
            return $check;
        }
    }

    public function editMatricula($object){
        if (!isset($object["id"]) || empty($object["id"])) return ["mensagem" => "Identificador da matrícula não informado!","status" => false];
        $check = $this->check($object);
        if ($check["status"]){
            $matricula = $this->find($object["id"]);
            $matricula->id_aluno = $object["id_aluno"];
            $matricula->id_curso = $object["id_curso"];
            return $this->saveOrUpdateMatricula($matricula);
        }else{
            return $check;
        }
    }

    public function deleteMatricula($object){
        if (!isset($object["id"]) || empty($object["id"])) return ["mensagem" => "Identificador da matrícula não informado!","status" => false];
        if ($this->destroy($object["id"])){
            return ["mensagem" => "Matrícula excluída com sucesso!","status" => true];
        }else{
            return ["mensagem" => "Não foi possível excluir a matrícula","status" => false];
        }
    }
}
