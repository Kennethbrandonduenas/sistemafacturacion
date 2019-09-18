<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;

class UserController extends Controller 
{
    public function login(Request $request)
    {
        try{
            $userdataconsult = User::select('email', 'username', 'name', 'role')->where('email', $request->usernameoremail)->orWhere('username',$request->usernameoremail);
            $userexist = $userdataconsult->count() === 1;
            if($userexist){
                $requestisemail = $request->isemail;
                $isemailequaltrue =  $requestisemail === 'true';
                $auth = null;
                if($isemailequaltrue){
                    $auth = Auth::attempt(['email' => $request->usernameoremail,'password' => $request->password]);
                }else{
                    $auth = Auth::attempt(['username' => $request->usernameoremail,'password' => $request->password]);
                };
                
                if ($auth){
                    $usergetdata = $userdataconsult->get();
                    return response()->json(['success' => true, 'userstorage' => $usergetdata], 200);
                }
                return response()->json(['success' => false, 'message' => 'Contraseña Incorrecta'], 400);
                //return response()->json(['success' => true, 'array' => $usergetdata], 200);
                //$checkpasswordiscorrect = 
            }else{
                return response()->json(['success' => false, 'message' => 'Usuario no Registrado con estos datos'], 400);
            };
            

        }catch (Exception $e){
            return response()->json(['success' => false, 'error' => $e], 500);
        };
    }
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $user = new User();
            $userexistwiththisemail = $user::select('id')->where('email', $request->email)->count();
            $userexistwiththisusername = $user::select('id')->where('username', $request->username)->count();
            $usernotexistwiththisemail = $userexistwiththisemail === 0;
            $usernotexistwiththisusername = $userexistwiththisusername === 0;
            if($usernotexistwiththisemail && $usernotexistwiththisusername){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role = $request->role;
                $user->username = $request->username;
                $user->active = $request->active;
                $user->password = bcrypt($request->password);      
                $user->save();
                DB::commit();
                return response()->json(['success' => true, 'message' => 'User Registered'], 200);
            }else if (!$usernotexistwiththisemail) {
                return response()->json(['success' => false, 'message' => 'Existe un Usuario con este email'], 400);
            }else if(!$usernotexistwiththisusername){
                return response()->json(['success' => false, 'message' => 'Existe un Usuario con este nombre de usuario'], 400);
            }
        }catch (Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e], 500);
        }
    }
    
}