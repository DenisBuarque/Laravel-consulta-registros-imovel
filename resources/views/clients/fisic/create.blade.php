@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif

            @if (session('erro'))
                <div class="alert alert-danger">
                    {{ session('erro') }}
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
                Formulário de cadastro pessoa física:
                <a href="{{ route('clients.index') }}" class="pull-right">Lista de registros</a>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('clients.fisic.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="people" value="PF">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="name">* Nome completo:</label>
                                <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" class="form-control" id="name" maxlength="50" autofocus>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="cpf">* CPF:</label>
                                <input type="text" name="cpf" value="{{ old('cpf') ? old('cpf') : '' }}" class="form-control" id="cpf" maxlength="11" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="rg">* RG / CIC:</label>
                                <input type="text" name="rg" value="{{ old('rg') ? old('rg') : '' }}" class="form-control" id="rg" maxlength="20" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="ssp">* SSP/UF:</label>
                                <input type="text" name="ssp" value="{{ old('ssp') ? old('ssp') : '' }}" class="form-control" id="ssp" maxlength="10" onkeyup="maiuscula(this)">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="profession">* Profissão:</label>
                                <input type="text" name="profession" value="{{ old('profession') ? old('profession') : '' }}" class="form-control" id="profession" maxlength="50">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="nationality">* Nacionalidade:</label>
                                <input type="text" name="nationality" value="{{ old('nationality') ? old('nationality') : '' }}" class="form-control" id="nationality" maxlength="50">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="civil_state">* Estado civil:</label>
                                <select name="civil_state" class="form-control">
                                    <option value=""></option>
                                    @php
                                        $options = array('1' => 'Solteiro(a)', '2' => 'Casado(a)', '3' => 'Divorciado(a)', '4' => 'Viúvo(a)');
                                    @endphp
                                    @foreach($options as $key => $value){
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="spouse">Cônjuge:</label>
                                <select name="spouse" class="form-control">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value){
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-10 form-group">
                                <label for="address">* Endereço:</label>
                                <input type="text" name="address" value="{{ old('address') ? old('address') : '' }}" class="form-control" id="address" maxlength="256">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="number">* Nº:</label>
                                <input type="text" name="number" value="{{ old('number') ? old('number') : '' }}" class="form-control" id="number" maxlength="5"> 
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="cep">CEP:</label>
                                <input type="text" name="cep" value="{{ old('cep') ? old('cep') : '' }}" class="form-control" id="cep" maxlength="9" onKeyPress="return formatCep(this, event)">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="district">* Bairro:</label>
                                <input type="text" name="district" value="{{ old('district') ? old('district') : '' }}" class="form-control" id="district" maxlength="50">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="city">* Cidade:</label>
                                <input type="text" name="city" value="{{ old('city') ? old('city') : '' }}" class="form-control" id="city" maxlength="50">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="state">* Estado:</label>
                                <input type="text" name="state" value="{{ old('state') ? old('state') : '' }}" class="form-control" id="state" maxlength="2" onkeyup="maiuscula(this)">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="phone">Telefone:</label>
                                <input type="tel" name="phone" value="{{ old('phone') ? old('phone') : '' }}" class="form-control" id="phone" maxlength="9" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" name="email" value="{{ old('email') ? old('email') : '' }}" class="form-control" id="email" maxlength="100" placeholder="Opcional">
                            </div>
                            <div class="col-md-8 form-group">
                                <br>
                                <input type="checkbox" name="new" value="S" checked> Ao finalizar iniciar novo cadastro.
                            </div>
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
