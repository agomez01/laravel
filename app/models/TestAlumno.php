<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class TestAlumno extends Model
    {

/*

SELECT t.id AS idtest, p.titulo AS prueba, s.nombre AS sector, t_a.realizado AS realizado, a.curso as curso
from test t
join test_alumno t_a on t.id = t_a.test
join alumno a on t_a.alumno = a.id
join prueba p on p.id = t.prueba
join sector s on s.id = t_a.sector
where t_a.alumno =  178633 AND t.visible = 1 and a.curso = 11681
AND t.estado < 2 
AND  unix_timestamp() >= t.fechaini 
AND  
AND  
order by t.id desc;


SELECT t.id AS idtest, p.titulo AS prueba, s.nombre AS sector, t_a.realizado AS realizado, a.*
from test t
join test_alumno t_a on t.id = t_a.test
join alumno a on t_a.alumno = a.id
join prueba p on p.id = t.prueba
join sector s on s.id = t_a.sector
where t_a.alumno =  178633 AND t.visible = 1 and a.curso = 11681 AND t.estado > 1 AND (t_a.realizado > 0 OR  unix_timestamp()  >= ( t.fechafin + (3600*24)-1))
order by t.id desc  limit 5;

*/

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'test_alumno';

        public static function getTestActivosDelAlumno($idalumno,$curso)
        {
       		$instante = time();

        	$data = \DB::table('test_alumno')
                        ->select(['test.id as idtest', 'prueba.titulo as nombre', 'sector.nombre as asignatura' ])
                        ->join('test', 'test.id','=','test_alumno.test')
                        ->join('alumno' , 'test_alumno.alumno','=','alumno.id')
                        ->join('prueba' , 'prueba.id','=','test.prueba')
                        ->join('sector' , 'sector.id','=','test_alumno.sector')
                        ->where('test_alumno.alumno' , $idalumno)
                        ->where('test.visible' , 1)
                        ->where('alumno.curso' , $curso)
                        ->where('test.estado', '<', 2)
                        ->whereRaw('test.fechaini <='.$instante)
                        ->whereRaw('(test.fechafin + (3600*24)-1) >='.$instante)
                        ->where('test_alumno.realizado' , '=' , 0)
                        ->orderBy('test.id' , 'desc')
                        ->get();

            return $data;

        }
        
        public static function getTestCerradosDelAlumno($idalumno,$curso)
        {

        	$instante = time();

        	$data = \DB::table('test_alumno')
                        ->select(['test.id as idtest', 'prueba.titulo as nombre', 'sector.nombre as asignatura' ])
                        ->join('test', 'test.id','=','test_alumno.test')
                        ->join('alumno' , 'test_alumno.alumno','=','alumno.id')
                        ->join('prueba' , 'prueba.id','=','test.prueba')
                        ->join('sector' , 'sector.id','=','test_alumno.sector')
                        ->where('test_alumno.alumno' , $idalumno)
                        ->where('test.visible' , 1)
                        ->where('alumno.curso' , $curso)
                        ->where('test.estado', '>', 1)
                        ->whereRaw('(test_alumno.realizado > 0 OR  '.$instante.' >= ( test.fechafin + (3600*24)-1))')
                        ->orderBy('test.id' , 'desc')
                        ->limit('5')
                        ->get();

            return $data;

        }
       
    }


