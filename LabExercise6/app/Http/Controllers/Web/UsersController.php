<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use DB;
use Artisan;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Mail\VerificationEmail;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordEmail;
use App\Mail\PasswordResetEmail;

class UsersController extends Controller {

	use ValidatesRequests;

    public function list(Request $request) {
        if(!auth()->user()->hasPermissionTo('show_users'))abort(401);
        $query = User::select('*');
        $query->when($request->keywords, 
        fn($q)=> $q->where("name", "like", "%$request->keywords%"));
        $users = $query->get();
        return view('users.list', compact('users'));
    }

	public function register(Request $request) {
        return view('users.register');
    }

    public function doRegister(Request $request) {

    	try {
    		$this->validate($request, [
	        'name' => ['required', 'string', 'min:5'],
	        'email' => ['required', 'email', 'unique:users'],
	        'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
	    	]);
    	}
    	catch(\Exception $e) {

    		return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
    	}

    	
    	$user =  new User();
	    $user->name = $request->name;
	    $user->email = $request->email;
	    $user->password = bcrypt($request->password); //Secure
	    $user->save();

        $title = "Verification Link";
        $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        $link = route("verify", ['token' => $token]);
        Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
        return redirect('/');

    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request) {
    	
    	if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);

        if(!$user->email_verified_at)
            return redirect()->back()->withInput($request->input())->withErrors('Your email is not verified.');


        return redirect('/');
    }

    public function doLogout(Request $request) {
    	
    	Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null) {
   
        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }
    
        $roles = [];
        foreach(Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach(Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }      

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user) {

        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if(auth()->user()->hasPermissionTo('admin_users')) {

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }

        //$user->syncRoles([1]);
        //Artisan::call('cache:clear');

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function delete(Request $request, User $user) {

        if(!auth()->user()->hasPermissionTo('delete_users')) abort(401);

    

        return redirect()->route('users');
    }

    public function editPassword(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user) {

        if(auth()->id()==$user?->id) {
            
            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if(!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                
                Auth::logout();
                return redirect('/');
            }
        }
        else if(!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); //Secure
        $user->save();

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function verify(Request $request) {
   
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if(!$user) abort(401);
        $user->email_verified_at = Carbon::now();
        $user->save();

        return view('users.verified', compact('user'));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed.'); // Handle errors
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = User::updateOrCreate([
                'facebook_id' => $facebookUser->id,
            ], [
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'facebook_token' => $facebookUser->token,
                'facebook_refresh_token' => $facebookUser->refreshToken,
            ]);
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Facebook login failed.');
        }
    }

    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->user();
            $user = User::updateOrCreate([
                'microsoft_id' => $microsoftUser->id,
            ], [
                'name' => $microsoftUser->name,
                'email' => $microsoftUser->email,
                'microsoft_token' => $microsoftUser->token,
                'microsoft_refresh_token' => $microsoftUser->refreshToken,
            ]);
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Microsoft login failed.');
        }
    }

    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedInCallback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();
            $user = User::updateOrCreate([
                'linkedin_id' => $linkedinUser->id,
            ], [
                'name' => $linkedinUser->name,
                'email' => $linkedinUser->email,
                'linkedin_token' => $linkedinUser->token,
                'linkedin_refresh_token' => $linkedinUser->refreshToken,
            ]);
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'LinkedIn login failed.');
        }
    }

    public function forgotPassword() {
        return view('users.forgot_password');
    }

    public function sendResetPassword(Request $request) {
        try {
            $this->validate($request, [
                'email' => ['required', 'email', 'exists:users,email'],
            ]);

            $user = User::where('email', $request->email)->first();
            
            // Generate a secure token
            $token = Str::random(64);
            
            // Store the token in the database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );

            // Generate the reset link
            $resetLink = route('reset_password', ['token' => $token]);

            // Send email with reset link
            Mail::to($user->email)->send(new PasswordResetEmail($resetLink, $user->name));

            return redirect()->back()->with('success', 'A password reset link has been sent to your email.');
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send reset password email. Please try again later.');
        }
    }

    public function showResetPasswordForm($token) {
        $tokenData = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();

        if (!$tokenData) {
            return redirect()->route('login')->with('error', 'Invalid or expired password reset link.');
        }

        return view('users.reset_password', ['token' => $token]);
    }

    public function updatePassword(Request $request) {
        try {
            $this->validate($request, [
                'token' => 'required',
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            $tokenData = DB::table('password_reset_tokens')
                ->where('token', $request->token)
                ->where('created_at', '>', now()->subMinutes(60))
                ->first();

            if (!$tokenData) {
                return redirect()->route('login')->with('error', 'Invalid or expired password reset link.');
            }

            $user = User::where('email', $tokenData->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            // Delete the used token
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            return redirect()->route('login')->with('success', 'Your password has been reset successfully. Please login with your new password.');
        } catch (\Exception $e) {
            \Log::error('Password update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

} 










































