<?php

namespace sysPluri;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use sysPluri\curso;

class matricula extends Model
{
    protected $table = "matricula";
    protected $fillable = ['id_curso', 'id_aluno'];

    public function aluno(){
        return $this->belongsTo('sysPluri\aluno', 'id_aluno', 'id');
    }

    public function curso(){
        return $this->belongsTo('sysPluri\curso', 'id_curso', 'id');
    }

    public function searchAll(){
        return $this->all();
    }

    public function countAlunosSexo($matriculas, $returns){
        // captura quantidade por sexo
        foreach ($matriculas as $mat){
            if ($mat["aluno"]["sexo"] == "Masculino"){ $returns["sexo"]["Masculino"] += 1; }
            else if ($mat["aluno"]["sexo"] == "Feminino"){ $returns["sexo"]["Feminino"] += 1; }
            else { $returns["sexo"]["Outro"] += 1; }
        }
        return $returns;
    }

    public function searchMatriculaPorIdade($idadeMinima = null, $idadeMaxima = null){
        $returns = ['curso' => [], 'sexo' => ["Masculino" => 0, "Feminino" => 0, "Outro" => 0]];
        $cursos = curso::all()->toArray();

        if ($idadeMinima != null && $idadeMaxima == null){
            $ano        = date('Y') - $idadeMinima;
            $dataMinima = $ano. "-". (date('m')+1) . "-" . date('d');            
            
            foreach ($cursos as $curso){

                // Captura todas as matriculas que possuem idade menor que a informada
                $matriculas = matricula::with('aluno')
                ->whereHas('aluno', function($q) use ($dataMinima){ $q->where("data_nascimento", ">", $dataMinima); })
                ->where('id_curso', '=', $curso['id'])
                ->get()
                ->toArray();
                $returns = $this->countAlunosSexo($matriculas, $returns);
                $returns["curso"][] = [$curso["titulo"] => count($matriculas)];
            }
        }

        if ($idadeMinima != null && $idadeMaxima != null){
            $ano        = date('Y') - $idadeMinima;
            $dataMinima = $ano. "-12-31"; 
            $anoMaximo  = date('Y') - $idadeMaxima;
            $dataMaxima = $anoMaximo. "-01-01";           
            
            foreach ($cursos as $curso){

                // Captura todas as matriculas que possuem idade menor que a informada
                $matriculas = matricula::with('aluno')
                ->whereHas('aluno', function($q) use ($dataMinima, $dataMaxima){ $q->whereBetween("data_nascimento", [$dataMaxima, $dataMinima]); })
                ->where('id_curso', '=', $curso['id'])
                ->get()
                ->toArray();
                $returns = $this->countAlunosSexo($matriculas, $returns);
                $returns["curso"][] = [$curso["titulo"] => count($matriculas)];
            }

        }

        if ($idadeMinima == null && $idadeMaxima != null){
            $ano        = date('Y') - $idadeMaxima;
            $dataMaxima = $ano. "-". (date('m')+1) . "-" . date('d');            
            
            foreach ($cursos as $curso){

                // Captura todas as matriculas que possuem idade menor que a informada
                $matriculas = matricula::with('aluno')
                ->whereHas('aluno', function($q) use ($dataMaxima){ $q->where("data_nascimento", "<", $dataMaxima); })
                ->where('id_curso', '=', $curso['id'])
                ->get()
                ->toArray();
                $returns = $this->countAlunosSexo($matriculas, $returns);
                $returns["curso"][] = [$curso["titulo"] => count($matriculas)];
                
            }
        }
        
        return $returns;
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
