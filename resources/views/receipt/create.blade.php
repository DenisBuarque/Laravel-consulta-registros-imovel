@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @if (session('alert'))
                <div class="alert alert-danger">
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
                Formulário cadastro de recibo
                <a href="{{ route('receipt.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('receipt.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="valor">* Valor:</label>
                                <input type="text" name="total_value" value="{{ old('total_value') ? old('total_value') : '' }}" class="form-control" id="valor" placeholder="0,00" autofocus onkeyup="moeda(this);" maxlength="15">
                                @if ($errors->has('venal_value'))
                                    <span class="help-block">
                                        <small class="form-text text-muted text-danger">{{ $errors->first('total_value') }}</small>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-8 form-group"></div>
                            <div class="col-md-12 form-group">
                                <label for="buyer">* Cliente:</label>
                                <select name="client_id" class="form-control" id="buyer">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value)
                                        @if(!empty($value->company))
                                            <option value="{{ $value->id }}">{{ $value->company }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="imovel_id">* Endereço do imóvel:</label>
                                <select name="imovel_id" class="form-control" id="imovel_id">
                                    <option value=""></option>
                                    @foreach($imovels as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->address }}, {{ $value->number }}, {{ $value->district }}, {{ $value->city }}/{{ $value->state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
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
