@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

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
                Formulário editar solicitação certidão
                <a href="{{ route('certificates.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('certificates.update', $certificate->id) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="client_id">* Solicitante:</label>
                                <select name="client_id" class="form-control" id="client_id">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value)
                                        @if($certificate->client_id == $value->id)
                                            @if(!empty($value->company))
                                                <option value="{{ $value->id }}" selected>{{ $value->company }}</option>
                                            @else
                                                <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                            @endif
                                        @else
                                            @if(!empty($value->company))
                                                <option value="{{ $value->id }}">{{ $value->company }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                
                                <label for="registry">* Cartorio:</label>
                                <select name="registry" class="form-control" id="registry">
                                    <option value=""></option>
                                    <option value="1" @php if($certificate->registry == 1){ echo 'selected'; } @endphp >Cartório de notas</option>
                                    <option value="2" @php if($certificate->registry == 2){ echo 'selected'; } @endphp >Cartório de registros</option>
                                </select>
                            </div>
                            @php
                                $array_craft = array(
                                    '1' => '1º Registro de imóvel',
                                    '2' => '2º Registro de imóvel',
                                    '3' => '3º Registro de imóvel',
                                    '4' => '1º Ofício',
                                    '5' => '2º Ofício',
                                    '6' => '3º Ofício',
                                    '7' => '4º Ofício',
                                    '8' => '5º Ofício',
                                    '9' => '6º Ofício'
                                );
                            @endphp
                            <div class="col-md-4 form-group">
                                <label for="craft">* Cartorio de ofício:</label>
                                <select name="craft" class="form-control" id="craft">
                                    <option value=""></option>
                                    @foreach($array_craft as $key => $value)
                                        @if($certificate->craft == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @php
                                $array_certificate = array(
                                    '1' => 'Certidão de ônus',
                                    '2' => 'Certidão de inteiro teor',
                                    '3' => 'Certidão vintenária',
                                    '4' => 'Certidão cinquentenária',
                                    '5' => 'Certidão de escritura',
                                    '6' => 'Certidão de procuração'
                                );
                            @endphp
                            <div class="col-md-4 form-group">
                                <label for="certificate">* Tipo de certidão:</label>
                                <select name="certificate" class="form-control" id="certificate">
                                    <option value=""></option>
                                    @foreach($array_certificate as $key => $value)
                                        @if($certificate->certificate == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="imovel_id">* Endereço do imóvel:</label>
                                <select name="imovel_id" class="form-control" id="imovel_id">
                                    <option value=""></option>
                                    @foreach($imovels as $key => $value)
                                        @if($certificate->imovel_id == $value->id)
                                            <option value="{{ $value->id }}" selected>{{ $value->client->name }} - {{ $value->address }}, {{ $value->number }}, {{ $value->city }}/{{ $value->state }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->client->name }} - {{ $value->address }}, {{ $value->number }}, {{ $value->city }}/{{ $value->state }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="book">Livro de Registro:</label>
                                <input type="text" name="book" class="form-control" value="{{ old('book') ? old('book') : $certificate->book }}" maxlength="20">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="sheet">Nº Folha:</label>
                                <input type="text" name="sheet" class="form-control" value="{{ old('sheet') ? old('sheet') : $certificate->sheet }}" maxlength="20">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="transcription">Transcrição:</label>
                                <input type="text" name="transcription" class="form-control" value="{{ old('transcription') ? old('transcription') : $certificate->transcription }}" maxlength="20">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="date_registry">Data do registro:</label>
                                <input type="date" name="date_registry" class="form-control" value="{{ old('date_registry') ? old('date_registry') : $certificate->date_registry_usa }}" maxlength="10">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="imovel_id">Observações sobre o imóvel:</label>
                                <textarea name="description" class="description">{{ $certificate->description }}</textarea>
                            </div>                            
                            <div class="col-md-8 form-group">
                                
                                <label for="witness_2">Foto do documento do imóvel:</label>
                                <input type="file" name="arquivo[]" multiple="true">
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
