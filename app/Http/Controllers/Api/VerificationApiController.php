<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidationEmail;
use App\Mail\AdminnewuserEmail;

class VerificationApiController extends Controller
{
//use VerifiesEmails;
/**
* Show the email verification notice.
*
*/
public function show()
{
//
}
/**
* Mark the authenticated user’s email address as verified.
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
public function verify(Request $request) {
$userID = $request['id'];
$user = User::find($userID);


Mail::to($user['email'])->send(new ValidationEmail($user));


$date = date("Y-m-d g:i:s");
$user->email_verified_at = $date; // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
$user->save();

return response()->json($user, 200);




}
/**
* Resend the email verification notification.
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
public function resend(Request $request)
{
if ($request->user()->hasVerifiedEmail()) {
return response()->json('User already have verified email!', 422);
// return redirect($this->redirectPath());
}
$request->user()->sendEmailVerificationNotification();
return response()->json('The notification has been resubmitted');
// return back()->with(‘resent’, true);
}


public function VerifyEmail(Request $request)
{
    $token = $request->token;

    if($token == null) {
        session()->flash('message', 'Invalid Login attempt');
        return redirect()->route('login');
    }
    $user = User::where('remember_token',$token)->first();

   if (!$user->hasVerifiedEmail()) {
    $user->markEmailAsVerified();
  } else {
    redirect()->route('error');
  }


//  session()->flash('message', 'Your account is activated, you can log in now');
 return redirect()->route('home');

}




public function verifywithcode(Request $request) {
 

  $userID = $request['id'];
  $verifcode = $request['verifycode'];
  $user = User::find($userID);
   if($user['code']=$verifcode){
    $user->markEmailAsVerified();

   Mail::to($user['email'])->send(new ValidationEmail($user));
  
   // return response()->json(['user'=>$user], $this-> successStatus);
 return response()->json($user, 200);
  }

  

  
  
  
  
  }
}
