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
                    Formulário cadastro taxa de registro:
                    <a href="{{ route('registrationfee.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('registrationfee.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="vl_ref">* Valor de referência:</label>
                                <input type="text" name="vl_ref" value="{{ old('vl_ref') ? old('vl_ref') : '' }}" class="form-control" id="vl_ref"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="codigo">* Código:</label>
                                <input type="text" name="codigo" value="{{ old('codigo') ? old('codigo') : '' }}" class="form-control" id="codigo" maxlength="5">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="ate_valor">* Ate valor:</label>
                                <input type="text" name="ate_valor" value="{{ old('ate_valor') ? old('ate_valor') : '' }}" class="form-control" id="ate_valor"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="custo_total">* Custo total:</label>
                                <input type="text" name="custo_total" value="{{ old('custo_total') ? old('custo_total') : '' }}" class="form-control" id="custo_total"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
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
