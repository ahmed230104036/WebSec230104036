<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function verifySecurityAnswer(Request $request)
    {
        $request->validate([
            'email_or_mobile' => 'required',
        ]);

        $user = User::where('email', $request->email_or_mobile)
                    ->orWhere('mobile_number', $request->email_or_mobile)
                    ->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $tempPassword = Str::random(10);
        $user->password = bcrypt($tempPassword);
        $user->save();

        if ($user->email == $request->email_or_mobile) {
            Mail::raw("Your temporary password is: $tempPassword", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Temporary Password');
            });

            return redirect()->route('login')->with('success', 'A temporary password has been sent to your email.');
        }

        if ($user->mobile_number == $request->email_or_mobile) {
            $this->sendWhatsAppMessage($user->mobile_number, "Your temporary password is: $tempPassword");

            return redirect()->route('login')->with('success', 'A temporary password has been sent to your phone.');
        }

        return back()->with('error', 'Invalid input.');
    }

    private function sendWhatsAppMessage($phoneNumber, $message)
    {
        $response = Http::post('https://api.twilio.com/send-message', [
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        return $response->successful();
    }
}
































// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Http;

// class ForgotPasswordController extends Controller