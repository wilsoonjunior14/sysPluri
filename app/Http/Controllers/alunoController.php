<?php

namespace sysPluri\Http\Controllers;

use Request;

use sysPluri\aluno;
use sysPluri\curso;

class alunoController extends Controller
{

    protected $aluno = null;

    public function __construct(){
        $this->aluno = new aluno();
    }

    public function index(){
        $alunos = $this->aluno->searchAll();
        return response()->json($alunos);
    }

    public function get($id){
        $aluno = $this->aluno::find($id);
        return response()->json($aluno);
    }

    public function add(){
        $returns = $this->aluno->saveAluno(Request::all());
        return response()->json($returns);
    }

    public function search(){
        $object = Request::all();
        if (!empty($object["nome"]) && strlen($object["nome"]) > 255) return ["mensagem" => "Nome de aluno muito extenso! Máximo de 255 caracteres permitidos", "status" => false];
        if (!empty($object["email"]) && strlen($object["email"]) > 255) return ["mensagem" => "Email de aluno muito extenso! Máximo de 255 caracteres permitidos", "status" => false];
        
        $returns = $this->aluno->searchAluno($object);
        return response()->json($returns);
    }


    public function edit(){
        $returns = $this->aluno->editAluno(Request::all());
        return response()->json($returns);
    }

    public function delete(){
        $returns = $this->aluno->deleteAluno(Request::all());
        return response()->json($returns);
    }
}
