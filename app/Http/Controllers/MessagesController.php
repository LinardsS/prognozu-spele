<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessagesController extends Controller
{
    //SA-001
    public function submit(Request $request){
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required'
      ]);

      // Create new message
      $message = new Message;
      $message->name = $request->input('name');
      $message->email = $request->input('email');
      $message->message = $request->input('message');
      //Save message
      $message->save();

      //Redirect
      return redirect('/')->withSuccess('Message Sent');
    }

    public function getMessages(){
      $messages = Message::all();

      return view('messages')->with('messages', $messages);
    }
}
