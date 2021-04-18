@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                Formulário de envio de e-mail
                <a href="" class="pull-right">Lista de registros</a>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('receiptemail.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">* Nome:</label>
                                <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" class="form-control" id="name" maxlength="50">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="email">* E-mail:</label>
                                <input type="email" name="email" value="{{ old('email') ? old('email') : '' }}" class="form-control" id="email" maxlength="50">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="subject">* Assunto:</label>
                                <input type="text" name="subject" value="{{ old('subject') ? old('subject') : '' }}" class="form-control" id="subject" maxlength="50">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="ssp">* Mensagem:</label>
                                <textarea name="message" class="description"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <br>
                                <button type="submit" class="btn btn-primary pull-right">Salvar Mensagem</button>
                            </div>
                        </div>
                    
                    </form>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
