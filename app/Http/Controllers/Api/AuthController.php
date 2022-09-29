<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Trait\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use PhpParser\Node\Stmt\TryCatch;

use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{use HttpResponses;
    public function createUser(StoreUserRequest $request){

        try{
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password'=> hash::make($request->password)
            ]);

            $factory = (new Factory)->withServiceAccount(__DIR__.'/laravel-app-bc690-firebase-adminsdk-lsrie-fd8832949b.json');
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $userRef = $database->collection('User')->newDocument();
            $userRef->set([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password)
            ]);

            return $this->success([
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ],200);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }

    }

    public function register(StoreUserRequest $request) 
    {
        $request->validated($request->only(['name', 'email', 'password']));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }


    public function loginUser(LoginUserRequest $request){
        
        try{
            

            if(!Auth::attempt($request->only(['email','password']))){
                return $this->error('','Credentials do not math',401);
            }
        
            $user = User::where('email',$request->email)->first();
       
         


            return $this->success([
                'user'=> $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ],200);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }

    }

    public function logoutUser(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status'=> true,
                'message' => 'User have been logged out successfully'
            ]);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }

    }


        
    
    
}
