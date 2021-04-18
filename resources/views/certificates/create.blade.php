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
                Formulário solicitação de certidão
                <a href="{{ route('certificates.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">

                    <script>
                        function habilitaCampos() {
                            var value = document.getElementById('registry').value;
                            if (value === '1') { 
                                document.getElementById('box-registry').style.display = "block";
                            } else if (value === '2') {
                                document.getElementById('box-registry').style.display = "none";
                            } else {
                                document.getElementById('box-registry').style.display = "none";
                            }
                        }

                        function closeInputs(){
                            document.getElementById('box-registry').style.display = "none";
                        }

                        let myGreeting = setTimeout(function() {
                            closeInputs();
                            clearAlert();
                        }, 100);

                        function clearAlert() {
                            window.clearTimeout(myGreeting);
                        }
                    </script>

                    <form method="POST" action="{{ route('certificates.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="client_id">* Solicitante:</label>
                                <select name="client_id" class="form-control" id="client_id">
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
                            <div class="col-md-3 form-group">
                                <label for="registry">* Cartorio:</label>
                                <select name="registry" class="form-control" id="registry" onchange="habilitaCampos()">
                                    <option value=""></option>
                                    <option value="1">Cartório de registros</option>
                                    <option value="2">Cartório de notas</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="craft">* Cartório de ofício:</label>
                                <select name="craft" class="form-control" id="craft">
                                    <option value=""></option>
                                    <option value="1">1º Registro de imóvel</option>
                                    <option value="2">2º Registro de imóvel</option>
                                    <option value="3">3º Registro de imóvel</option>

                                    <option value="4">1º Ofício</option>
                                    <option value="5">2º Ofício</option>
                                    <option value="6">3º Ofício</option>
                                    <option value="7">4º Ofício</option>
                                    <option value="8">5º Ofício</option>
                                    <option value="9">6º Ofício</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="certificate">* Tipo de certidão:</label>
                                <select name="certificate" class="form-control" id="certificate">
                                    <option value=""></option>
                                    <option value="1">Certidão de ônus</option>
                                    <option value="2">Certidão de inteiro teor</option>
                                    <option value="3">Certidão vintenária</option>
                                    <option value="4">Certidão cinquentenária</option>

                                    <option value="5">Certidão de escritura</option>
                                    <option value="6">Certidão de procuração</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="imovel_id">* Endereço do imóvel:</label>
                                <select name="imovel_id" class="form-control" id="imovel_id">
                                    <option value=""></option>
                                    @foreach($imovels as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->client->name }} - {{ $value->address }}, {{ $value->number }}, {{ $value->city }}/{{ $value->state }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id='box-registry'>
                                <div class="col-md-3 form-group">
                                    <label for="book">Livro de Registro:</label>
                                    <input type="text" name="book" class="form-control" value="{{ old('book') ? old('book') : '' }}" maxlength="20">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="sheet">Nº Folha:</label>
                                    <input type="text" name="sheet" class="form-control" value="{{ old('sheet') ? old('sheet') : '' }}" maxlength="20">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="transcription">Transcrição:</label>
                                    <input type="text" name="transcription" class="form-control" value="{{ old('transcription') ? old('transcription') : '' }}" maxlength="20">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="date_registry">Data do registro:</label>
                                    <input type="date" name="date_registry" class="form-control" value="{{ old('date_registry') ? old('date_registry') : '' }}" maxlength="10">
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="imovel_id">Observações sobre o imóvel:</label>
                                <textarea name="description" class="description"></textarea>
                            </div>                            
                            <div class="col-md-8 form-group">
                                <br>
                                <label for="witness_2">Foto de documento do imóvel</label>
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
