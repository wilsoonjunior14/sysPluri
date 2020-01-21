<?php

namespace sysPluri\Http\Controllers;

use Request;
use sysPluri\curso;

class cursoController extends Controller
{

    protected $curso = null;

    public function __construct(){
        $this->curso = new curso();
    }

    public function index(){
        $cursos = $this->curso->searchAll();
        return response()->json($cursos);
    }

    public function get($id){
        $curso = $this->curso::find($id);
        return response()->json($curso);
    }

    public function add(){
        $returns = $this->curso->saveCurso(Request::all());
        return response()->json($returns);
    }

    public function edit(){
        $returns = $this->curso->editCurso(Request::all());
        return response()->json($returns);
    }

    public function delete(){
        $returns = $this->curso->deleteCurso(Request::all());
        return response()->json($returns);
    }
}
