<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class Test extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'test';


        public function miPrueba()
        {

            return $this->belongsTo('App\models\Prueba', 'prueba','id');

        }

        public function misPreguntas()
        {

            return $this->hasMany('App\models\TestPregunta','test','id');

        }


        public static function getDatosDelTest($idtest)
        {

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


        /*
            return  Array
        */
        public function getArrayRetroAttribute(){

            $cuociente = (int)$this->modulos;

            while($cuociente >= 1)  
            {
                $resto =  $cuociente % 2; 
                $cuociente = (int)($cuociente / 2);                  
                $binario[] = $resto;
            }

            return $binario;
        }
    }