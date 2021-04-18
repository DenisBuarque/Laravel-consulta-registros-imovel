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
                    Formulário de edição declaração de imóvel:
                    <a href="{{ route('declaration.index') }}" class="pull-right">Lista de registros</a>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('declaration.update', $declaration->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="living_room">* Sala(s):</label>
                                <input type="text" name="living_room" value="{{ old('living_room') ? old('living_room') : $declaration->living_room }}" class="form-control" id="living_room" maxlength="2" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="bedroom">* Quarto(s):</label>
                                <input type="text" name="bedroom" value="{{ old('bedroom') ? old('bedroom') : $declaration->bedroom }}" class="form-control" id="bedroom" maxlength="2" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="kitchen">* Cozinha(s):</label>
                                <input type="text" name="kitchen" value="{{ old('kitchen') ? old('kitchen') : $declaration->kitchen }}" class="form-control" id="kitchen" maxlength="2" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="bathroom">* Banheiro(s):</label>
                                <input type="text" name="bathroom" value="{{ old('bathroom') ? old('bathroom') : $declaration->bathroom }}" class="form-control" id="bathroom" maxlength="2" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="garage">* Garagem(s):</label>
                                <input type="text" name="garage" value="{{ old('garage') ? old('garage') : $declaration->garage }}" class="form-control" id="garage" maxlength="2" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="service_area">* Área de serviço:</label>
                                <input type="text" name="service_area" value="{{ old('service_area') ? old('service_area') : $declaration->service_area }}" class="form-control" id="service_area" maxlength="2" onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="front_area">* Área de frente:</label>
                                <input type="text" name="front_area" value="{{ old('front_area') ? old('front_area') : $declaration->front_area }}" class="form-control" id="front_area" maxlength="10" placeholder="Tamanho m/2">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="funds_area">* Área de fundos:</label>
                                <input type="text" name="funds_area" value="{{ old('funds_area') ? old('funds_area') : $declaration->funds_area }}" class="form-control" id="funds_area" maxlength="10" placeholder="Tamanho m/2">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="left_area">* Área esquerda:</label>
                                <input type="text" name="left_area" value="{{ old('left_area') ? old('left_area') : $declaration->left_area }}" class="form-control" id="left_area" maxlength="10" placeholder="Tamanho m/2">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="right_area">* Área direita:</label>
                                <input type="text" name="right_area" value="{{ old('right_area') ? old('right_area') : $declaration->right_area }}" class="form-control" id="right_area" maxlength="10" placeholder="Tamanho m/2">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="building_area">* Área construida:</label>
                                <input type="text" name="building_area" value="{{ old('building_area') ? old('building_area') : $declaration->building_area }}" class="form-control" id="building_area" maxlength="10" placeholder="Tamanho m/2">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="ground_area">* Área terreno:</label>
                                <input type="text" name="ground_area" value="{{ old('ground_area') ? old('ground_area') : $declaration->ground_area }}" class="form-control" id="ground_area" maxlength="10" placeholder="Tamanho m/2">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="imovel_id">* Imóvel:</label>
                                <select name="imovel_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($imovels as $key => $value){
                                        @if($declaration->imovel_id == $value->id)
                                            <option value="{{ $value->id }}" selected>{{ $value->address }}, nº {{ $value->number }}, {{ $value->distrity }}, {{ $value->city }}/{{ $value->state }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->address }}, nº {{ $value->number }}, {{ $value->district }}, {{ $value->city }}/{{ $value->state }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="client_id">* Outorgante declarante:</label>
                                <select name="client_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value){
                                        @if($declaration->client_id == $value->id)
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
                            <div class="col-md-3 form-group">
                                <label for="witness_1">* Testemunha 1:</label>
                                <select name="witness_1" class="form-control">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value){
                                        @if($declaration->witness_1 == $value->id)
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
                            <div class="col-md-3 form-group">
                                <label for="witness_2">* Testemunha 2:</label>
                                <select name="witness_2" class="form-control">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value){
                                        @if($declaration->witness_2 == $value->id)
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
                            <div class="col-md-6 form-group">
                                <label for="confront_front">Confrontande de frente do imóvel:</label>
                                <input type="text" name="confront_front" value="{{ old('confront_front') ? old('confront_front') : $declaration->confront_front }}" class="form-control" id="confront_front" maxlength="100" placeholder="Informações do que se localiza a frente do imóvel.">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="confront_funds">Confrontande de fundos do imóvel:</label>
                                <input type="text" name="confront_funds" value="{{ old('confront_funds') ? old('confront_funds') : $declaration->confront_funds }}" class="form-control" id="confront_funds" maxlength="100" placeholder="Informações do que se localiza a frente o imóvel.">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="confront_right">Confrontande a direita do imóvel:</label>
                                <input type="text" name="confront_right" value="{{ old('confront_right') ? old('confront_right') : $declaration->confront_right }}" class="form-control" id="confront_right" maxlength="100" placeholder="Informações do que se localiza a rireita do imóvel.">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="confront_left">Confrontande a esquerda do imóvel:</label>
                                <input type="text" name="confront_left" value="{{ old('confront_left') ? old('confront_left') : $declaration->confront_left }}" class="form-control" id="confront_left" maxlength="100" placeholder="Informações do que se localiza a frente o imóvel.">
                            </div>
                            @php 
                                ($declaration->tipo == 'D') ? $checked1 = 'checked' : $checked1 = '';
                                ($declaration->tipo == 'C') ? $checked2 = 'checked' : $checked2 = '';
                            @endphp
                            <div class="col-md-3 form-group">
                                <label>Modelo de documento:</label><br>
                                <input type="radio" name="tipo" value="D" {{ $checked1 }}> Declaração de posse
                            </div>
                            <div class="col-md-3 form-group">
                                <br>
                                <input type="radio" name="tipo" value="C" {{ $checked2 }}> Cessão de posse
                            </div>
                            <div class="col-md-3 form-group"></div>
                            <div class="col-md-3 form-group">
                                <br>
                                <button type="submit" class="btn btn-primary btn-block pull-right">Salvar Dados</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
