<?php
    namespace App\Http\Controllers\Auth;

    # Modelos
    use App\models\Alumno;
    use App\models\Colegio;
    use App\models\Curso;
    use App\models\Sesion;
    use App\models\Usuario;
    use App\models\Variables;

    # Controladores
    use Validator;
    use Session;
    use App\Http\Controllers\Controller;

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

        private function setSesion($data){

            $sesion = new Sesion();
            $sesion->usuario_id = $data->id;
            $sesion->save();

            $usuario = Usuario::find($data->id);

            $var['id']              =   $data->id;
            $var['tema']            =   $usuario->idtema;
            $var['user']            =   $usuario->nombre_usuario;
            $var['rol']             =   $usuario->idrol;
            $var['colegio']         =   $usuario->idcolegio;
            $var['anio']            =   $this->obtener_anio($usuario->idcolegio);
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

            Session::put('logeado',     true);
            Session::put('idusuario',   $usuario->id);
            Session::put('colegio',     $usuario->idcolegio);
            Session::put('rol',         $usuario->idrol);
            
        }


        static function logout(){

            $id = Session::get('idusuario');

            $sesion = Sesion::where('usuario_id', $id)->first();

            Variables::where('auth_sesion_id', $sesion->id)->delete();

            $sesion->delete();

            Session::flush();

            return true;
        }


        public function obtener_anio($colegio){

            $curso = Curso::select('ano')
                            ->where('colegio', $colegio)
                            ->where('visible',1)
                            ->orderBy('ano', 'desc')
                            ->first();
                       
            return $curso->ano;
        }

        public function generarCodigoSesion()   
        {
            $code = sha1(mt_rand().time().mt_rand().$_SERVER['REMOTE_ADDR']);
            return $code;
        }
        
    }
