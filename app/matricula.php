<?php

namespace sysPluri;

use Illuminate\Database\Eloquent\Model;

class matricula extends Model
{
    protected $table = "matriculas";
    protected $fillable = ['id_curso', 'id_aluno'];
}
