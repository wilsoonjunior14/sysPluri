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

    function index(){
        $alunos = $this->aluno->searchAll();
        return response()->json($alunos);
    }

    function get($id){
        $aluno = $this->aluno::find($id);
        return response()->json($aluno);
    }

    function add(){
        $returns = $this->aluno->saveAluno(Request::all());
        return response()->json($returns);
    }


    function edit(){
        $returns = $this->aluno->editAluno(Request::all());
        return response()->json($returns);
    }

    function delete(){
        $returns = $this->aluno->deleteAluno(Request::all());
        return response()->json($returns);
    }
}
