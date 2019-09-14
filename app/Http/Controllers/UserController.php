<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller 
{
    public $successStatus = 200;
    public $errorValidator = 401;
    public function register(Request $request) 
    { 
        $rules = [
            'email' => 'required|email|unique:users',
            'name' => 'required|min:50',
            'password' => 'required|min:200',
            'active' => 'required|min:2',
            'username' => 'required|email|unique:users',
            'role' => 'required|min:10'
        ];

        $messages = [
            'email.required' => 'Es necesario especificar una dirección de correo electrónico.',
            'email.email' => 'El campo e-mail no tiene el formato adecuado.',
            'email.unique' => 'El e-mail es único por cada usuario, ya que se usará para acceder al sistema.',
            'name.required' => 'Es necesario ingresar los nombres del usuario.',
            'name.min' => 'Ingrese un nombre adecuado.',
            'username.required' => 'Es necesario ingresar un nombre de usuario.',
            'username.min' => 'Ingrese un nombre de usuario adecuado.',
            'active.required' => 'Es necesario que pongas que la persona esta activa o no',
            'active.min' => 'Solo son 2 digitos 0 ó 1',
            'role.required' => 'Escriba el rol del usuario, es necesario',
            'role.min' => 'Solo son 15 carácteres'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            $response = Response::json('Error', $errorValidator);
        };

        $user = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'active' => $request->get('active'),
            'role' => $request->get('role')
        ]);
        $user->save();
        response()->json(['success'=>$success], $this-> successStatus); 
    }
}