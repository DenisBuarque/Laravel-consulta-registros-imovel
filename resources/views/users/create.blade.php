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
                    Formulário de cadastro de usuário
                    <a href="{{ route('users.index') }}" class="pull-right">Lista de registros</a>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">* Nome:</label>
                                <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" class="form-control" id="name" maxlength="50" autofocus>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="email">* email:</label>
                                <input type="email" name="email" value="{{ old('email') ? old('email') : '' }}" class="form-control" id="email" maxlength="100">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="email">* Permissões:</label>
                                <select name="permissions[]" class="form-control" multiple>
                                    @foreach($permissions as $key => $value)
                                        @php
                                            $selected = '';
                                            if( old('permissions') ):
                                                foreach ( old('permissions') as $key => $value2 ):
                                                    if($value->id == $value2->id ):
                                                        $selected = 'selected';
                                                    endif;
                                                endforeach;
                                            endif;
                                        @endphp
                                        <option {{ $selected }} value="{{ $value->id }}">{{ $value->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="password">* Senha:</label>
                                <input type="password" name="password" value="{{ old('password') ? old('password') : '' }}" class="form-control" id="email" maxlength="10">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="password-confirm" class="control-label">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="col-md-8 form-group"></div>
                            <div class="col-md-4 form-group">
                                <br>
                                <button type="submit" class="btn btn-primary btn-block">Salvar Dados</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
