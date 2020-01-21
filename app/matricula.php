<?php

namespace sysPluri;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class matricula extends Model
{
    protected $table = "matricula";
    protected $fillable = ['id_curso', 'id_aluno'];

    public function alunos(){
        return $this->hasMany('sysPluri\aluno', 'id', 'id_aluno');
    }

    public function searchAll(){
        return $this->all();
    }

    public function searchMatriculaPorIdade($idadeMinima, $idadeMaxima = null){
        $ano        = date('Y') - $idadeMinima;
        $dataMinima = $ano. "-". (date('m')+1) . "-" . date('d');

        if ($idadeMaxima === null){
            
            return $this->whereHas('alunos', function($q) use ($dataMinima){
                $q->where("data_nascimento", ">", $dataMinima);
            })
            ->with('alunos')
            ->get();

        }else{

        }
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
