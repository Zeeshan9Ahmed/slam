<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\User\Auth\ResendSignUpOtpRequest;
use App\Http\Requests\Api\User\Auth\ResetForgotPasswordRequest;
use App\Http\Requests\Web\VenueSignUpRequest;
use App\Models\OtpCode;
use App\Models\User;
use App\Models\Venue;
use App\Services\OTP\AccountVerification;
use App\Services\OTP\GenerateOTP;
use App\Services\OTP\ValidateOTP;
use App\Services\User\AccountVerificationOTP;
use App\Services\User\CreateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class SignUpController extends Controller
{
    public function signUpForm()
    {
        return view('web.register.signup');
    }

    public function loginForm()
    {
        return view('web.register.login');
    }

    public  function forgotPasswordForm()
    {
        return view('web.register.forgot_password');
    }

    public function otpForm()
    {
        return view('web.register.otp');
    }

    public function profileSetupForm()
    {
        return view('web.register.venue_profile');
    }

    public function changePasswordForm()
    {
        return view('web.register.change_password');
    }


    public function signUp(VenueSignUpRequest $request)
    {
        if ($request->password != $request->confirm) 
            return commonErrorMessage('Password and Confirm Password must be same', 200);

        $data = $request->only('full_name', 'email') + ['device_type' => 'web', 'role' => 'venue', 'password' => bcrypt($request->password)];

        $user = app(CreateUser::class)->execute($data);

        $sendOtp = app(AccountVerificationOTP::class)->execute(['user' => $user]);


        return response()->json([
            'status' => 1,
            'redirect_url' => url('/admin/venue/otp'),
            'message' => 'OTP verification code has been sent to your email address',
            'data' => ['email' => $user->email, 'type' => 'ACCOUNT_VERIFICATION'],
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'venue'])) {
            $user = Auth::user();
            if ($user->email_verified_at == null) {
                Auth::logout();
                return response()->json([
                    'status' => 1,
                    'redirect_url' => url('business/otp'),
                    'message' => 'Account is not Verified, please Verify your account',
                    'data' => ['email' => $user->email, 'type' => 'ACCOUNT_VERIFICATION'],
                ]);
            }

            return response()->json([
                'status' => 1,
                'redirect_url' => url('/admin/dashboard'),
                'message' => 'Login Successfully',
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Invalid Credentials',
        ]);
    }

    public function updateProfile(Request $request)
    {
       $user = Auth::user();

        $user->phone_number = $request->phone_number;
        $user->full_name = $request->full_name;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('/uploadedimages'), $imageName);
            $avatar = asset('uploadedimages') . "/" . $imageName;
            $user->avatar = $avatar;
        }
        $user->profile_completed = 1;
        $user->save();

        $venue_image = "";


        $data =  [
            'name' =>  $request->venue_name,
            'capacity' =>  $request->capacity,
            'detail' =>  $request->detail,
            'phone_number' =>  $request->venue_number,
            'start_time' => date('h:i A', strtotime($request->start_time)),
            'end_time' => date('h:i A', strtotime($request->end_time)), 
        ];

        if ($request->address){
            $data['address'] =  $request->address;
        }

        if ($request->latitude){
            $data['lat'] =  $request->latitude;
        }
        if ($request->longitude){
            $data['lang'] =  $request->longitude;
        }
       
        if ($request->hasFile('venue_image')) {
            $imageName = time() . '.' . $request->venue_image->getClientOriginalExtension();
            $request->venue_image->move(public_path('/uploadedimages'), $imageName);
            $venue_image = asset('uploadedimages') . "/" . $imageName;
            $data['image'] = $venue_image;
        }

        $venue = Venue::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );
        // $request->session()->put('venue_id', $venue->id);

        return response()->json([
            'status' => 1,
            'redirect_url' => url('/admin/dashboard'),
            'message' => 'Profile Updated',
        ]);
        return redirect()->route('venue_dashboard');
    }


    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
            session()->flash('success','Log Out Successfully');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return commonErrorMessage("Invalid Email", 200);
        }



        $data = ['email' => $user->email, 'type' => 'PASSWORD_RESET'];

        OtpCode::where(['email' => $request->email, 'ref' => 'PASSWORD_RESET'])->delete();
        $otp = app(GenerateOTP::class)->execute($data);

        // Mail::to($user->email)->send(new ForgotPasswordOTPMail($user,$otp));
        return response()->json([
            'status' => 1,
            'redirect_url' => url('/admin/venue/otp'),
            'message' => 'OTP verification code has been sent to your email address',
            'data' => ['email' => $user->email, 'type' => 'PASSWORD_RESET'],
        ]);
        return apiSuccessMessage("OTP verification code has been sent to your email address", ['id' => $user->id]);
    }


    public function otpVerify(Request $request)
    {
        $data = $request->all();
        $reference_code = $data['digit_1'] . $data['digit_2'] . $data['digit_3'] . $data['digit_4'] . $data['digit_5'] . $data['digit_6'];

        $set_data = $request->only('email', 'type') + ['reference_code' => $reference_code];

        // dd($set_data);

        $check_otp = app(ValidateOTP::class)->execute($set_data);

        if ($request->type === "ACCOUNT_VERIFICATION") {
            $user = app(AccountVerification::class)->execute(['email' => $check_otp->email]);
            $user = Auth::login($user);
            return response()->json([
                'status' => 1,
                'redirect_url' => url('/admin/venue/profile-setup'),
                // 'message' => '',
                'data' => ['reference_code' => $reference_code],
            ]);
        } elseif ($request->type === "PASSWORD_RESET") {
            return response()->json([
                'status' => 1,
                'redirect_url' => url('/admin/venue/change-password'),
                // 'message' => '',
                'data' => ['reference_code' => $reference_code],
            ]);
        }
    }

    public function resetForgotPassword(ResetForgotPasswordRequest $request)
    {
        $check_otp = app(ValidateOTP::class)->execute(['email' => $request->email, 'reference_code' => $request->reference_code, 'type' => 'PASSWORD_RESET']);

        if (!$check_otp) {
            return commonErrorMessage("Invalid Otp ", 400);
        }

        $user = User::where('email', $check_otp->email)->first();
        $user->password = bcrypt($request->new_password);
        $user->save();
        $check_otp->delete();
        return response()->json([
            'status' => 1,
            'redirect_url' => url('/admin/venue/login'),
            'message' => 'Password updated successfully',

        ]);
    }
    public function resendSignUpOtp(ResendSignUpOtpRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return commonErrorMessage("No User Found", 200);
        }

        if ($user->email_verified_at != null) {
            return commonErrorMessage("Account already verified", 200);
        }

        $otp_code = app(AccountVerificationOTP::class)->execute(['user' => $user]);

        return commonSuccessMessage("We have resend  OTP verification code at your email address", 200);
    }
}
