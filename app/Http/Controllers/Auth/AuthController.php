<?php
    namespace App\Http\Controllers\Auth;

    # Modelos
    use App\models\Alumno;
    use App\models\Colegio;
    use App\models\Curso;
    use App\models\Sesion;
    use App\models\Usuario;
    use App\models\Variables;
    

    use Illuminate\Support\Facades\Event;
    # Controladores
    use Validator;
    use Session;
    use App\Http\Controllers\Controller;
    use DB;
    class AuthController extends Controller {

        static function logear($data){

            # Verificamos los datos
            $validator = Validator::make($data, [
                'nombre_usuario' => 'required|max:255',
                'clave' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                # si existen problemas al validar, enviamos el detalle al form login
                return redirect('/login')
                            ->withErrors($validator)
                            ->withInput();

            }else{

                $usuario = Usuario::where('visible',1)
                                    ->where('nombre_usuario', $data['nombre_usuario'])
                                    ->where('clave', $data['clave'])
                                    ->first();

                if(count($usuario) > 0){

                    $auth = new AuthController();
                    $auth->setSesion($usuario);

                    return "ok";
                }else{
                    return false;
                }             
            }
        }
        
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'username' => 'required|max:255',
                'password' => 'required|max:255',
            ]);
        }

        public function setSesion($data){

            # Si existe una sesión iniciada con el mismo usuario, esta se elimina
            Sesion::where('usuario_id', $data->id)->delete();

            $sesion = new Sesion();
            $sesion->usuario_id = $data->id;

            if(!isset($data->token)){
                $sesion->token = $data->token;
            }else{
                $sesion->token = Session::token();
            }

            $sesion->token = Session::token();

            $sesion->save();

            $usuario = Usuario::find($data->id);

            $anio = $this->obtener_anio($usuario->idcolegio);

            $var['id']              =   $data->id;
            $var['tema']            =   $usuario->idtema;
            $var['user']            =   $usuario->nombre_usuario;
            $var['rol']             =   $usuario->idrol;
            $var['colegio']         =   $usuario->idcolegio;
            $var['anio']            =   $anio;
            $var['curriculum']      =   $usuario->colegio->curriculum;
            $var['full-name']       =   $usuario->usuario_detalle->full_name;
            $var['school-name']     =   $usuario->colegio->nombre;
            $var['plataforma']      =   PLATAFORMA;
            $var['portadas']        =   $usuario->idrol;
            $var['tema_usuario']    =   $usuario->idtema;
            $var['estado']          =   'ok';
            $var['modulos']         =   $usuario->colegio->modulos;

            $var['tiempoInicio']    =   $sesion->created_at->timestamp;
            $var['codigoSesion']    =   $this->generarCodigoSesion();

            $vars = new Variables();
            $vars->auth_sesion_id = $sesion->id;
            $vars->variables = serialize($var);
            $vars->save();

            if ($usuario->idrol == '31')
            {
                
                $dataAlumno = $this->obtenerDataDelAlumno($data->id, $anio);
                $dataCurso = Curso::find($dataAlumno[0]->idcurso);
                Session::put('curso',  $dataAlumno[0]->idcurso );
                Session::put('idalumno',   $dataAlumno[0]->idalumno);
                Session::put('nombre-curso',   $dataCurso->nombre);

            }

            Session::put('logeado',     true);
            Session::put('idusuario',   $usuario->id);
            Session::put('colegio',     $usuario->idcolegio);
            Session::put('rol',         $usuario->idrol);

            Session::put('full-name',   ucwords(mb_strtolower(($usuario->usuario_detalle->full_name), "utf-8")));
        }


        static function logout(){

            $id = Session::get('idusuario');

            $sesion = Sesion::where('usuario_id', $id)->first();

            Variables::where('auth_sesion_id', $sesion->id)->delete();

            $sesion->delete();

            Session::flush();

            return true;
        }

        static function comprueba($id, $token){

            $usr = Sesion::where('usuario_id', $id)
                        ->where('token', $token)->get();

            if(count($usr) > 0){
                return true;
            }else{
                return false;
            }
            
        }


        public function obtener_anio($colegio){

            $curso = Curso::select('ano')
                            ->where('colegio', $colegio)
                            ->where('visible',1)
                            ->orderBy('ano', 'desc')
                            ->first();
                       
            return $curso->ano;
        }

        public function obtenerDataDelAlumno($idusuario, $anio)
        {
           
            $data = \DB::table('alumno')
                        ->join('curso', 'alumno.curso' , '=' , 'curso.id')
                        ->select(['alumno.id as idalumno', 'curso.id as idcurso'])
                        ->where('alumno.estado' , '1')
                        ->where('alumno.habilitado' , '1')
                        ->where('alumno.alumno' , $idusuario)
                        ->where('curso.ano',$anio)
                        ->where('curso.visible', 1)->get();

            return $data;
            
        }


        public function generarCodigoSesion()   
        {
            $code = sha1(mt_rand().time().mt_rand().$_SERVER['REMOTE_ADDR']);
            return $code;
        }
        
    }
