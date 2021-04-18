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
                    Formulário de edição propriedade rural:
                    <a href="{{ route('incra.index') }}" class="pull-right">Lista de registros</a>
                </div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('incra.update', $incra->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="client_id">* Requerente:</label>
                                <select name="client_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($clients as $key => $value){
                                        @if($incra->client_id == $value->id)
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
                                <label for="denominacao">* Denominação do imovel rural:</label>
                                <input type="text" name="denominacao" value="{{ old('denominacao') ? old('denominacao') : $incra->denominacao }}" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="localization">*  Indicação para localização do imovel:</label>
                                <input type="text" name="localization" value="{{ old('localization') ? old('localization') : $incra->localization }}" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="total_area">* Área total:</label>
                                <input type="text" name="total_area" value="{{ old('total_area') ? old('total_area') : $incra->total_area }}" class="form-control" maxlength="10" placeholder='(ha)' onkeypress='return onlynumber();'>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="county">* Municipio sede de localização:</label>
                                <input type="text" name="county" value="{{ old('county') ? old('county') : $incra->county }}" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="zona">* Área localizada em zona urbana:</label>
                                <input type="text" name="zona" value="{{ old('zona') ? old('zona') : $incra->zona }}" class="form-control" maxlength="10" placeholder='(ha)'>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="state">* Estado sede:</label>
                                <input type="text" name="state" value="{{ old('state') ? old('state') : $incra->state }}" class="form-control" maxlength="2">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="latitude">Latitude:</label>
                                <input type="text" name="latitude" value="{{ old('latitude') ? old('latitude') : $incra->latitude }}" class="form-control" maxlength="30">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="logitude">Longitude:</label>
                                <input type="text" name="logitude" value="{{ old('logitude') ? old('logitude') : $incra->logitude }}" class="form-control" maxlength="30">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="nature">* Natureza da área:</label>
                                @php
                                $nature = array(
                                    '1' => 'Assentamento',
                                    '2' => 'Estrada',
                                    '3' => 'Ferrovia',
                                    '4' => 'Floresta Pública',
                                    '5' => 'Gleba Pública',
                                    '6' => 'Particular',
                                    '7' => 'Perímetro Urbano',
                                    '8' => 'Terra Indígena',
                                    '9' => 'Terreno de Marinha',
                                    '10' => 'Terreno Marginal',
                                    '11' => 'Território Quilombola',
                                    '12'=> 'Unidade de Conservação'
                                    );
                                @endphp
                                <select name="nature" class="form-control">
                                    <option value=""></option>
                                    @foreach($nature as $key => $value)
                                        @if($incra->nature == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="division_country">O imóvel rural se localiza em mais de um município? </label>
                                <input type="text" name="division_country" value="{{ old('division_country') ? old('division_country') : $incra->division_country }}" class="form-control" maxlength="255" placeholder="Informe o(s) município(s):">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="destiny">* Destinação do imóvel rural :</label>
                                <input type="text" name="destiny" value="{{ old('destiny') ? old('destiny') : $incra->destiny }}" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="text" name="dismemberment_area" value="{{ old('dismemberment_area') ? old('dismemberment_area') : $incra->dismemberment_area }}" class="form-control" maxlength="10" placeholder="(ha)">
                            </div>
                            <div class="col-md-10 form-group p-g-txt">
                                Informe o total da área desmembrada do imóvel se ocorreu demembramento.
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="text" name="anexo_area" value="{{ old('anexo_area') ? old('anexo_area') : $incra->anexo_area }}" class="form-control" maxlength="10" placeholder="(ha)">
                            </div>
                            <div class="col-md-10 form-group p-g-txt">
                                Informe a área de remembramento se correu anexação de área ao imovel rural.
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="text" name="area_add" value="{{ old('area_add') ? old('area_add') : $incra->area_add }}" class="form-control" maxlength="10" placeholder="(ha)">
                            </div>
                            <div class="col-md-10 form-group p-g-txt">
                                Informa a área de remembramento se ocorreu anexação NÃO cadastrado no imovel rural.
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="number" max='99' min='0' name="amount_family" value="{{ old('amount_family') ? old('amount_family') : $incra->amount_family }}" class="form-control" maxlength="3">
                            </div>
                            <div class="col-md-4 form-group p-g-txt">
                            * Qtd. famílias residentes:
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="number" max='99' min='0' name="amount_people" value="{{ old('amount_people') ? old('amount_people') : $incra->amount_people }}" class="form-control" maxlength="3">
                            </div>
                            <div class="col-md-4 form-group p-g-txt">
                                * Qtd. pessoas residentes:
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="number" max='99' min='0' name="salary_portfolio" value="{{ old('salary_portfolio') ? old('salary_portfolio') : $incra->salary_portfolio }}" class="form-control" maxlength="3">
                            </div>
                            <div class="col-md-4 form-group p-g-txt">
                                * Assalariados permanentes COM carteira assinada:
                            </div>

                            <div class="col-md-2 form-group p-g">
                            <input type="number" max='99' min='0' name="salary_not" value="{{ old('salary_not') ? old('salary_not') : $incra->salary_not }}" class="form-control" maxlength="3">
                            </div>
                            <div class="col-md-4 form-group p-g-txt">
                                * Assalariados permanentes SEM carteira assinada:
                            </div>
                            <div class="col-md-2 form-group p-g">
                                <input type="number" max='99' min='0' name="family_labor" value="{{ old('family_labor') ? old('family_labor') : $incra->family_labor }}" class="form-control" maxlength="3">
                            </div>
                            <div class="col-md-4 form-group p-g-txt">
                                * Mão de obra familiar
                            </div>
                            <div class="col-md-3 form-group">
                                @php
                                    $litigios = array(
                                        '1' => 'Questão de limite',
                                        '2' => 'Questão de titulação',
                                        '3' => 'Questão quanto ao domínio',
                                        '4' => 'Questão quanto a posse do domínio',
                                        '5' => 'Questão quanto a posse',
                                        '6' => 'Questão restrição use de terra',
                                        '7' => 'Servidão do acesso',
                                        '8' => 'Servidão do uso da água',
                                        '9' => 'Árae com posseiros'
                                        );
                                @endphp
                                <label for="litigation">Litigios:</label>
                                <select name="litigation" class="form-control">
                                    <option value=""></option>
                                    @foreach($litigios as $key => $value)
                                        @if($incra->litigation == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                @php
                                    $improvements = array(
                                        '1' => 'Benfeitoria',
                                        '2' => 'Comércio',
                                        '3' => 'Hotel fazenda',
                                        '4' => 'Industria',
                                        '5' => 'Mineração',
                                        '6' => 'Olaria',
                                        '7' => 'Pesque-pague',
                                        '8' => 'Outros'
                                        );
                                @endphp
                                <label for="improvement">* Beneficiamento:</label>
                                <select name="improvement" class="form-control">
                                    <option value=""></option>
                                    @foreach($improvements as $key => $value)
                                        @if($incra->improvement == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                @php
                                    $areas = array(
                                        '1' => 'Área com produtos vegetais isolados',
                                        '2' => 'Área com produtos vegetais em consorcio',
                                        '3' => 'Área com produtos vegetais em rotação',
                                        '4' => 'Área de exploração granja ou aquicola',
                                        '5' => 'Área com outros usos',
                                        '6' => 'Área de pastagem',
                                        '7' => 'Árae sem restrição sem uso',
                                        '8' => 'Área inaproveitável'
                                        );
                                @endphp
                                <label for="use_area">* Denominação:</label>
                                <select name="use_area" class="form-control">
                                    <option value=""></option>
                                    @foreach($areas as $key => $value)
                                        @if($incra->use_area == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="used_area">Área utilizada denominação:</label>
                                <input type="text" name="used_area" value="{{ old('use_area') ? old('use_area') : $incra->use_area }}" class="form-control" maxlength="100" placeholder="(ha)">
                            </div>
                            
                            <div class="col-md-3 form-group">
                                @php
                                    $improvements = array(
                                        '1' => 'Asinios',
                                        '2' => 'Bois de 3 anos e mais',
                                        '3' => 'Bois de 2 anos a menos de 3 anos',
                                        '4' => 'Bovinos de 1 a menos de 2 anos',
                                        '5' => 'Bovinos menos de 1 ano',
                                        '6' => 'Bibalinos',
                                        '7' => 'Caprinos',
                                        '8' => 'Equinos',
                                        '9' => 'Muares',
                                        '10' => 'Novilhos de 2 a menos de 3 anos',
                                        '11' => 'Novilhas precosse de 1 a menos de 2 anos',
                                        '12' => 'Novilhas precosse de 2 anos a menos',
                                        '13' => 'Novilhos precosse de 1 a menos de 2 anos',
                                        '14' => 'Novilhos precosse de 2 anos a menos',
                                        '15' => 'Ovinos',
                                        '16' => 'Touros (reprodutores)',
                                        '17' => 'Cacas de 3 anos e mais',
                                        );
                                @endphp
                                <label for="animal_category">Denominação animal:</label>
                                <select name="animal_category" class="form-control">
                                    <option value=""></option>
                                    @foreach($improvements as $key => $value)
                                        @if($incra->animal_category == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="amount_animal">Quantidade de animais:</label>
                                <input type="number" max='9999' min='0' name="amount_animal" value="{{ old('amount_animal') ? old('amount_animal') : $incra->amount_animal }}" class="form-control" maxlength="3">
                            </div>
                            <div class="col-md-9 form-group"></div>
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
