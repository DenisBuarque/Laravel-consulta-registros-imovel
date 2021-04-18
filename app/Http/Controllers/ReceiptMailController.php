<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptEmail;


class ReceiptMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('receiptemail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        Mail::send('receiptemail.message',[], function($messages){
            $messages->to('denisprogramadorweb@gmail.com');
            $messages->subject('Assunto do email enviado');
        });

        return 'ok';
       
    }

    public function storeUmEmail(Request $request)
    {
        /*$data = $request->all();
        Validator::make($data, [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'subject' => 'required|string|max:100',
            'message' => 'required|string',
        ]);*/

        Mail::to('denisbuarque@gmail.com')->send(new ReceiptEmail());
        return 'ok';
    }

    public function storeVariosEmails(Request $request)
    {
        Mail::send('receiptemail.message',[], function($messages){
            $address = ['denisprogramadorweb@gmail.com','falecom@coposalada.com.br']; // lista de e-mail
            $messages->to($address);
            $messages->subject('Assunto do email enviado');
        });
    }

    public function storeCopyEmail(Request $request)
    {
        Mail::send('receiptemail.message',[], function($messages){
            $messages->to('denisprogramadorweb@gmail.com');
            //$messages->cc('falecom@coposalada.com.br');//com cópia
            //$messages->cc(['email1@mail.com','email2@mail.com','email3@mail.com']);//com cópia
            $messages->bcc('falecom@coposalada.com.br');//com cópia oculta
            //$messages->bcc(['email1@mail.com','email2@mail.com','email3@mail.com']);//com cópia oculta
            $messages->subject('Assunto do email enviado');
        });
    }

    public function storeAnexoEmail(Request $request)
    {
        Mail::send('receiptemail.message',[], function($messages){
            $messages->to('denisprogramadorweb@gmail.com');
            $messages->subject('Assunto do email enviado');
            //$messages->attach('/pasta/arquivo/name.pdf');
            //$messages->attach(url('/pasta/arquivo/name.pdf')); // criar dentro da pasta /public
            $messages->attach('/pasta/arquivo', [
                'as' => 'name.pdf',
                'mime' => 'application/pdf',
            ]);
        });
    }
}
