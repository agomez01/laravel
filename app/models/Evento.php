<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;


    class Evento extends Model
    {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'evento';

        public function getFechaInicioAttribute(){

            #Wed May 01 2013 00:00:00 GMT-0400 (Hora est.

            $arri =   explode(" ", $this->fechaini );
            $mes = self::to_mes($arri[1]);
            $horain = $arri['2']."-".$mes."-".$arri['3']." ".substr($arri['4'], 0,-3);
            

            return $horain;
        }

        public function getFechaTerminoAttribute(){
            #Wed May 01 2013 00:00:00 GMT-0400 (Hora est. 

            $arrf   = explode(" ",$this->fechafin);
            $mes    = self::to_mes($arrf[1]);
            $horafi = $arrf['2']."-".$mes."-".$arrf['3']." ".substr($arrf['4'], 0,-3);


            return  $horafi;
        }

        static function to_mes($mes){

            switch ($mes) {
                case 'Jan': return "01"; break;
                case 'Feb': return "02"; break;
                case 'Mar': return "03"; break;
                case 'Apr': return "04"; break;
                case 'May': return "05"; break;
                case 'Jun': return "06"; break;
                case 'Jul': return "07"; break;
                case 'Aug': return "08"; break;
                case 'Sep': return "09"; break;
                case 'Oct': return "10"; break;
                case 'Nov': return "11"; break;
                case 'Dec': return "12"; break;
            }

        }


        public function evento_tipo(){

            return $this->hasOne('App\models\EventoTipo', 'id', 'tipo');
        }
        

    }
