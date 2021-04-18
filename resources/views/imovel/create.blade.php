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
                    Formulário de cadastro de imóvel
                    <a href="{{ route('imovel.index') }}" class="pull-right">Lista de Registros</a>
                </div>

                <div class="panel-body">

                    <script>
                        
                    function habilitaCampos() {
                        var value = document.getElementById('type_imovel').value;
                        if (value === '1' || value === '2') { // casa e terreno
                            document.getElementById('box-home').style.display = "block";
                            document.getElementById('box-allotment').style.display = "none";
                            document.getElementById('box-construction').style.display = "none";
                            document.getElementById('box-place').style.display = "none";
                            document.getElementById('box-farm').style.display = "none";
                            document.getElementById('box-quinta').style.display = "none";
                        } else if (value === '3') { // loteamento
                            document.getElementById('box-home').style.display = "block";
                            document.getElementById('box-allotment').style.display = "block";
                            document.getElementById('box-construction').style.display = "none";
                            document.getElementById('box-place').style.display = "none";
                            document.getElementById('box-farm').style.display = "none";
                            document.getElementById('box-quinta').style.display = "none";
                        } else if (value === '4') { // edificio
                            document.getElementById('box-home').style.display = "none";
                            document.getElementById('box-allotment').style.display = "none";
                            document.getElementById('box-construction').style.display = "block";
                            document.getElementById('box-place').style.display = "none";
                            document.getElementById('box-farm').style.display = "none";
                            document.getElementById('box-quinta').style.display = "none";
                        } else if (value === '5') { // sitio
                            document.getElementById('box-home').style.display = "none";
                            document.getElementById('box-allotment').style.display = "none";
                            document.getElementById('box-construction').style.display = "none";
                            document.getElementById('box-place').style.display = "block";
                            document.getElementById('box-farm').style.display = "none";
                            document.getElementById('box-quinta').style.display = "none";
                        } else if (value === '6') { // chacara
                            document.getElementById('box-home').style.display = "block";
                            document.getElementById('box-allotment').style.display = "none";
                            document.getElementById('box-construction').style.display = "none";
                            document.getElementById('box-place').style.display = "block";
                            document.getElementById('box-farm').style.display = "block";
                            document.getElementById('box-quinta').style.display = "none";
                        } else if (value === '7') { // fazenda
                            document.getElementById('box-home').style.display = "block";
                            document.getElementById('box-allotment').style.display = "none";
                            document.getElementById('box-construction').style.display = "none";
                            document.getElementById('box-place').style.display = "block";
                            document.getElementById('box-farm').style.display = "block";
                            document.getElementById('box-quinta').style.display = "block";
                        } else {
                            document.getElementById('box-home').style.display = "none";
                            document.getElementById('box-allotment').style.display = "none";
                            document.getElementById('box-construction').style.display = "none";
                            document.getElementById('box-place').style.display = "none";
                            document.getElementById('box-farm').style.display = "none";
                            document.getElementById('box-quinta').style.display = "none";
                        }
                    }

                    function closeInputs(){
                        document.getElementById('box-home').style.display = "none";
                        document.getElementById('box-allotment').style.display = "none";
                        document.getElementById('box-construction').style.display = "none";
                        document.getElementById('box-place').style.display = "none";
                        document.getElementById('box-farm').style.display = "none";
                        document.getElementById('box-quinta').style.display = "none";
                    }

                    let myGreeting = setTimeout(function() {
                        closeInputs();
                        clearAlert();
                    }, 100);

                    function clearAlert() {
                        window.clearTimeout(myGreeting);
                    }
                    </script>

                    <form method="POST" action="{{ route('imovel.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="client_id">* Representante legal:</label>
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
                            <div class="col-md-6 form-group">
                                <label for="type_imovel">* Tipo de imóvel:</label>
                                @php
                                    $array = array('1' => 'Casa', '2' => 'Terreno', '3' => 'Lotemaneto', '4' => 'Edifícil', '5' => 'Sitio', '6' => 'Chacara', '7' => 'Fazenda');
                                @endphp
                                <select name="type_imovel" id="type_imovel" class="form-control" onchange="habilitaCampos()">
                                    <option value=""></option>
                                    @foreach($array as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
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
                            <div class="col-md-3 form-group">
                                <label for="district">* Bairro:</label>
                                <input type="text" name="district" value="{{ old('district') ? old('district') : '' }}" class="form-control" id="district" maxlength="50">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="city">* Cidade:</label>
                                <input type="text" name="city" value="{{ old('city') ? old('city') : '' }}" class="form-control" id="city" maxlength="50">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="state">* Estado:</label>
                                <input type="text" name="state" value="{{ old('state') ? old('state') : '' }}" class="form-control" id="state" maxlength="2" onkeyup="maiuscula(this)">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="venal_value">* Valor venal do imóvel:</label>
                                <input type="text" name="venal_value" value="{{ old('venal_value') ? old('venal_value') : '' }}" class="form-control" id="venal_value" maxlength="15" onkeyup="moeda(this);">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="book">Livro  de registo nº:</label>
                                <input type="text" name="book" value="{{ old('book') ? old('book') : '' }}" class="form-control" id="book" maxlength="20">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sheet">Nº Folha:</label>
                                <input type="text" name="sheet" value="{{ old('sheet') ? old('sheet') : '' }}" class="form-control" id="sheet" maxlength="20">
                            </div>
                        </div>

                        <div id="box-home">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="iptu">IPTU:</label>
                                    <input type="text" name="iptu" value="{{ old('iptu') ? old('iptu') : '' }}" class="form-control" id="iptu" maxlength="20">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="registration">Nº Registro:</label>
                                    <input type="text" name="registration" value="{{ old('registration') ? old('registration') : '' }}" class="form-control" id="registration" maxlength="20">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="rip">RIP:</label>
                                    <input type="text" name="rip" value="{{ old('rip') ? old('rip') : '' }}" class="form-control" id="rip" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div id="box-allotment">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name_allotment">Nome do loteamento:</label>
                                    <input type="text" name="name_allotment" value="{{ old('name_allotment') ? old('name_allotment') : '' }}" class="form-control" id="name_allotment" maxlength="50">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="number_allotment">Nº do Loteamento:</label>
                                    <input type="text" name="number_allotment" value="{{ old('number_allotment') ? old('number_allotment') : '' }}" class="form-control" id="number_allotment" maxlength="10">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="block_allotment">Quadra:</label>
                                    <input type="text" name="block_allotment" value="{{ old('block_allotment') ? old('block_allotment') : '' }}" class="form-control" id="block_allotment" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div id="box-construction">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name_building">Nome do Edificil:</label>
                                    <input type="text" name="name_building" value="{{ old('name_building') ? old('name_building') : '' }}" class="form-control" id="name_building" maxlength="50">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="number_block">Bloco:</label>
                                    <input type="text" name="number_block" value="{{ old('number_block') ? old('number_block') : '' }}" class="form-control" id="number_block" maxlength="20">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="number_apartment">Nº Apartamento:</label>
                                    <input type="text" name="number_apartment" value="{{ old('number_apartment') ? old('number_apartment') : '' }}" class="form-control" id="number_apartment" maxlength="5">
                                </div>
                            </div>
                        </div>
                        <div id="box-place">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="ccir">CCIR:</label>
                                    <input type="text" name="ccir" value="{{ old('ccir') ? old('ccir') : '' }}" class="form-control" id="ccir" maxlength="20">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="itr">ITR:</label>
                                    <input type="text" name="itr" value="{{ old('itr') ? old('itr') : '' }}" class="form-control" id="itr" maxlength="20">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="incra">INCRA:</label>
                                    <input type="text" name="incra" value="{{ old('incra') ? old('incra') : '' }}" class="form-control" id="incra" maxlength="20">
                                </div>
                            </div>
                        </div>
                        <div id="box-farm">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="name_farm">Nome Chácara ou Fazenda:</label>
                                    <input type="text" name="name_farm" value="{{ old('name_farm') ? old('name_farm') : '' }}" class="form-control" id="name_farm" maxlength="100">
                                </div>
                            </div>
                        </div>
                        <div id="box-quinta">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="latitude">Latitude:</label>
                                    <input type="text" name="latitude" value="{{ old('latitude') ? old('latitude') : '' }}" class="form-control" id="latitude" maxlength="30">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="longitude">Longitude:</label>
                                    <input type="text" name="longitude" value="{{ old('longitude') ? old('longitude') : '' }}" class="form-control" id="longitude" maxlength="30">
                                </div>
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
