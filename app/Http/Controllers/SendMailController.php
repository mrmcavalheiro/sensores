<?php

namespace App\Http\Controllers;

use App\Mail\Contato;
use App\Mail\Sendmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function lead(Request $request){
        $name =$request->name;
        $tel  =$request->tel;
        $email=$request->email;
        $dadosEmail=[
            'name' => $name,
            'tel' => $tel,
            'email'=>$email
        ];
        Mail::to(env('MAIL_FROM_CONTATO'))->send(new Sendmail($dadosEmail));
        return redirect()->route('home');
    }

    public function contato(Request $request){
        $name =$request->name;
        $email=$request->email;
        $message  =$request->message;
        $dadosEmail=[
            'name' => $name,
            'email'=>$email,
            'message' => $message
        ];

        Mail::to(env('MAIL_FROM_CONTATO'))->send(new Contato($dadosEmail));
        return redirect()->route('contato');
    }
}
