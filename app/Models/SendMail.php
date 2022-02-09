<?php

namespace App\Models;

use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Mail as SimpleMail;
class SendMail
{
  
  public static function senior($data){
    $users = User::where('role_id',2)->get();
    foreach ($users as $user) {
      Mail::to($user)->send(new UserMail($data));
    }
  }
  
  public static function user(User $user, $data){ 
    Mail::to($user)->send(new UserMail($data));
  }

  public static function to($email, $data,$attach=null){ 
    SimpleMail::send('mail.template', ['data'=>$data], function($message) use($email, $data, $attach){
      $message->to($email, 'mail.template')
      ->subject($data["subject"]);

      if($attach !=null)
        $message->attachData($attach->output(), $attach->fullname);
    });
  }
}
