<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use DateTime;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getContact(){
      return view('contact');
    }
    //SA-001
    public function submit(Request $request){
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required'
      ]);
      // Check time of last message from this user to prevent from spamming
      $user = auth()->user();
      $lastMessage = Message::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
      if($lastMessage){
        $lastMessageTime = $lastMessage->created_at;
        $lastMessageTime = strtotime(date('Y-m-d H:i:s', strtotime($lastMessageTime)));
        $sysdate = new DateTime();
        $sysdate = $sysdate->format('Y-m-d H:i:s');
        $sysdate = strtotime(date('Y-m-d H:i:s', strtotime($sysdate)));
        $secsSince = $sysdate - $lastMessageTime;
        if($secsSince < 60){
          $secondsUntilResend = 60 - $secsSince;
          return redirect()->back()->withErrors(['msg' => 'Uzgaidiet '. $secondsUntilResend . ' sekundes līdz nākamās ziņas nosūtīšanai!']);
        }
      }
      // Create new message
      $message = new Message;
      $message->name = $request->input('name');
      $message->email = $request->input('email');
      $message->message = $request->input('message');
      $message->user_id = $user->id;
      $message->read = 0;
      //Save message
      $message->save();

      //Redirect
      return redirect('/')->withSuccess('Ziņa nosūtīta!');
    }

    public function getMessages(){
      $messages = Message::orderBy('created_at', 'desc')->get();

      return view('messages')->with('messages', $messages);
    }
    public function markAsRead(Message $message){
      $message->update(['read' => true]);

      return redirect()->back()->withSuccess('Ziņa atzīmēta kā lasīta!');
    }
    public function markAsUnread(Message $message){
      $message->update(['read' => false]);

      return redirect()->back()->withSuccess('Ziņa atzīmēta kā nelasīta!');
    }
}
