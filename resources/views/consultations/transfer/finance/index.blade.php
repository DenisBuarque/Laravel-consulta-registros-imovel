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
                Consulta Financiamento /
                <a href="{{ route('consultations.tranfer.finance.index') }}" title="Clique para acesssar o formulário de consulta de transferência.">Transferência</a>
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('consultations.tranfer.finance.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="valor">Informe o valor venal do imóvel:</label>
                            <input type="text" name="venal_value" value="{{ old('venal_value') ? old('venal_value') : '' }}" class="form-control" id="valor" placeholder="0,00" autofocus onkeyup="moeda(this);" maxlength="15">
                            @if ($errors->has('venal_value'))
                                <span class="help-block">
                                    <small class="form-text text-muted text-danger">{{ $errors->first('venal_value') }}</small>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="select">Total de Parcelas:</label>
                            <select name='portion' class="form-control" require>
                                <option value="12">12 parcelas</option>
                                <option value="24">24 parcelas</option>
                                <option value="36">36 parcelas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="iptu">Débito IPTU:</label> <small>(opcional)</small>
                            <input type="text" name="iptu_debit" value="{{ old('iptu_debit') ? old('iptu_debit') : '' }}" class="form-control" id="iptu" placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                        </div>
                        <div class="form-group">
                            <label for="condominium">Débito Condominium:</label> <small>(opcional)</small>
                            <input type="text" name="debit_condominium" value="{{ old('debit_condominium') ? old('debit_condominium') : '' }}" class="form-control" id="condominium" placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary pull-right">Realizar Consulta</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
