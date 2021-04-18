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
                Formulário cadastro de documento transferência
                <a href="{{ route('documents.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="buyer">* Comprador do imóvel:</label>
                                <select name="buyer" class="form-control" id="buyer">
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
                                <label for="seller">* Vendedor do imóvel:</label>
                                <select name="seller" class="form-control" id="seller">
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
                                        <option value="{{ $value->id }}">{{ $value->address }}, {{ $value->number }}, {{ $value->district }}, {{ $value->city }}/{{ $value->state }} ({{ $value->client->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="witness_1">Testemunha 1:</label> (Opcional)
                                <select name="witness_1" class="form-control" id="witness_1">
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
                                <label for="witness_2">Testemunha 2:</label> (Opcional)
                                <select name="witness_2" class="form-control" id="witness_2">
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
                                <label for="witness_2">Foto de documentos</label>
                                <input type="file" name="arquivo[]" multiple="true">
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
