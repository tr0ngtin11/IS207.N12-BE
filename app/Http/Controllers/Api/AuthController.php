<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Khachhang;
use App\Models\NguoiDung;
use App\Trait\HttpResponses;
use DateTime;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use HttpResponses;
    public function createUser(StoreUserRequest $request)
    {

        try {

            $user = NguoiDung::create([
                'hoten' => $request->hoten,
                'email' => $request->email,
                'role' => $request->role,
                'urlavt' => $request->urlavt,
                'password' => hash::make($request->password),




            ]);
            $customer = Khachhang::create([
                'id' => $user->id,
            ]);
            //a
            // $factory = (new Factory)->withServiceAccount(__DIR__.'/laravel-app-bc690-firebase-adminsdk-lsrie-fd8832949b.json');
            // $firestore = $factory->createFirestore();
            // $database = $firestore->database();
            // $userRef = $database->collection('User')->newDocument();
            // $userRef->set([
            //     'name' => $request->name,
            //     'email'=> $request->email,
            //     'password'=> Hash::make($request->password)
            // ]);

            return response()->json([
                'data' => $user,
                'status' => true,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // public function createUser(StoreUserRequest $request) 
    // {
    //     $request->validated($request->only(['name', 'email', 'password']));

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return $this->success([
    //         'user' => $user,
    //         // 'token' => $user->createToken('API Token')->plainTextToken,

    //     ]);
    // }


    public function loginUser(LoginUserRequest $request)
    {

        try {


            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->error('', 'Credentials do not math', 401);
            }

            $user = NguoiDung::where('email', $request->email)->first();
            $time_expiration_token = $user->createToken('API TOKEN')->accessToken->expires_at;
            // // $time_expiration_token1 = new DateTimeImmutable($time_expiration_token);
            // $format = 'Y-m-d H:i:s';
            // // $date = DateTimeImmutable::createFromFormat($format,$time_expiration_token);
            // // $date = DateTimeImmutable::cre($format,$time_expiration_token);
            // // $date->format('Y-m-d H:i:s');
            // // $time = $date->date;
            // $time_expiration_token->format(DateTime::RFC1036);
            //    $date =  date('Y-m-d H:i:s',$time_expiration_token);
            //    $date = $time_expiration_token->format('Y-m-d H:i:s');
            return $this->success([
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                // 'expires_at'=> $date
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logoutUser(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User have been logged out successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getUser(Request $request)
    {
        try {
            // get id user from jwt token
            $bearToken = $request->bearerToken();
            $idUser = PersonalAccessToken::findToken($bearToken)->tokenable_id;
            $user = NguoiDung::find($idUser);
            $ngaysinh = new DateTimeImmutable($user->ngsinh);
            $ngaysinh = $ngaysinh->format('Y-m-d');
            $user->ngsinh = $ngaysinh;
            return response()->json([
                'status' => true,
                'user' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, NguoiDung $nguoidung)
    {
        try {
            $nguoidung->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Sửa thông tin thành công",
                'user' => $nguoidung,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function changePassword(Request $request)
    {
        //get password from database and compare with request

        // if (!Auth::attempt($request->only(['password']))) {
        //     return $this->error('', 'Mật khẩu không chính xác', 401);
        // }
        $user = NguoiDung::where('email', $request->email)->first();
        $isMatchOldPassword = hash::check($request->password, $user->password);
        if ($isMatchOldPassword == true) {
            $user->password = hash::make($request->newPassword);
            $user->save();
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Đổi mật khẩu thành công'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu không chính xác'
            ], 401);
        }
    }

    public function forgotpw(Request $request)
    {
        //get value from request
        $mail = $request->email;
        $user = NguoiDung::where('email', $mail)->first();
        $numberOTP = rand(100000, 999999);
        Mail::send('mail.test', [], function ($message) use ($mail) {
            $message->to($mail, 'MoriiCoffee');
            $message->from('moriicoffeee@gmail.com');
            $message->subject('Mã OTP');
        });

        return response()->json([
            'status' => true,
            'message' => 'OTP has been sent to your email',
            'numberOTP' => $user,
        ], 200);
    }

    public function checkEmailExist($email)
    {
        Log::info($email);
        $user = NguoiDung::where('email', $email)->first();
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Email có tồn tại',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email không tồn tại',
            ], 401);
        }
    }

    public function resetPassword(Request $request)
    {
        Log::info($request->all());
        $user = NguoiDung::where('email', $request->email)->first();
        $user->password = hash::make($request->newPassword);
        $user->save();
        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'Đổi mật khẩu thành công'
        ], 200);
    }
}
