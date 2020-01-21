<?php

namespace sysPluri;

use Illuminate\Database\Eloquent\Model;

class curso extends Model
{
    protected $table = "curso";
    protected $fillable = ['descricao', 'titulo'];

    public function searchAll(){
        return curso::all();
    }

    public function check($object){
        if (strlen($object["titulo"]) <= 0 || strlen($object["titulo"]) > 255) return ["mensagem" => "Título do curso inválido! Título deve conter entre 0 e 255 caracteres", "status" => false];
        return ["mensagem" => "", "status" => true];
    }

    public function saveOrUpdateCurso($object){
        if ($object->save()){
            return ["mensagem" => "Curso {$object['titulo']} salvo com sucesso!", "status" => true];
        }else{
            return ["mensagem" => "Não foi possível salvar o curso {$object['titulo']}!", "status" => false]; 
        }
    }

    public function saveCurso($object){
        $check = $this->check($object);
        if ($check["status"]){
            $newCurso = new curso($object);
            return $this->saveOrUpdateCurso($newCurso);
        }else{
            return $check;
        }
    }

    public function editCurso($object){
        if (strlen($object["id"]) <= 0) return ["mensagem" => "Identificador do curso não informado!","status" => false];
        $check = $this->check($object);
        if ($check["status"]){
            $curso = curso::find($object["id"]);
            $curso->descricao = isset($object["descricao"]) ? $object["descricao"] : $curso->descricao;
            $curso->titulo    = $object["titulo"];
            return $this->saveOrUpdateCurso($curso);
        }else{
            return $check;
        }
    }

    public function deleteCurso($object){
        if (strlen($object["id"]) <= 0) return ["mensagem" => "Identificador do curso não informado!","status" => false];
        if (curso::destroy($object["id"])){
            return ["mensagem" => "O curso foi excluído com sucesso!", "status" => true];
        }else{
            return ["mensagem" => "Não foi possível excluir o curso!", "status" => false];
        }
    }

}
