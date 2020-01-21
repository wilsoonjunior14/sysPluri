<?php

namespace sysPluri\Http\Controllers;

use Request;
use sysPluri\matricula;
use sysPluri\aluno;
use sysPluri\curso;
use Illuminate\Support\Facades\DB;

class matriculaController extends Controller
{
    protected $matricula = null;
    protected $aluno     = null;
    protected $curso     = null;

    public function __construct(){
        $this->matricula = new matricula();
        $this->aluno     = new aluno();
        $this->curso     = new curso();
    }

    public function index(){
        return response()->json($this->matricula->searchAll());
    }

    public function get($id){
        return response()->json($this->matricula->find($id));
    }

    public function delete(){
        $returns = $this->matricula->deleteMatricula(Request::all());
        return response()->json($returns);
    }

    public function edit(){
        $returns = $this->matricula->editMatricula(Request::all());
        return response()->json($returns);
    }

    public function add(){
        $returns = $this->matricula->saveMatricula(Request::all());
        return response()->json($returns);
    }

    public function addCourses(){

        if (empty(Request::input('id_aluno'))) return ["mensagem" => "Identificador de aluno não informado!", "status" => false];
        if (empty(Request::input('cursos'))) return ["mensagem" => "Nenhum curso informado!", "status" => false];

        $aluno  = $this->aluno::find(Request::input('id_aluno'))->toArray();
        $cursos = json_decode(Request::input('cursos'), true);

        DB::beginTransaction();
        $error  = false;
        $return = [];
        foreach ($cursos as $curso){
            $object = ["id_aluno" => $aluno["id"], "id_curso" => $curso["id"]];
            $returns= $this->matricula->saveMatricula($object);  
            if (!$error && !$returns["status"]){
                $error   = true;
                $return  = $returns;
            } 
        }
        if ($error){
            DB::rollback();
            return response()->json($return);
        } 

        DB::commit();
        return response()->json(["mensagem" => "Aluno matriculado com sucesso no(s) curso(s).", "status" => true]);
    }

    public function search(){
        $returns = [];
        $returns[] = ['Alunos com menos de 15 anos de idade'     => $this->matricula->searchMatriculaPorIdade(15)];
        $returns[] = ['Alunos com idade entre 15 anos e 18 anos' => $this->matricula->searchMatriculaPorIdade(15, 18)];
        $returns[] = ['Alunos com idade entre 19 anos e 24 anos' => $this->matricula->searchMatriculaPorIdade(19, 24)];
        $returns[] = ['Alunos com idade entre 25 anos e 30 anos' => $this->matricula->searchMatriculaPorIdade(25, 30)];
        $returns[] = ['Alunos com mais de 30 anos de idade'      => $this->matricula->searchMatriculaPorIdade(null, 30)];
        return response()->json($returns);
    }
}
