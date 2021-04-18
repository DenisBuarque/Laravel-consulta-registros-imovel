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
                    Formulário alterar taxa de escritura:
                    <a href="{{ route('deedfee.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('deedfee.update', $deedfee->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="vl_referencia">* Valor de referência:</label>
                                <input type="text" name="vl_referencia" value="{{ old('vl_referencia') ? old('vl_referencia') : $deedfee->vl_referencia }}" class="form-control" id="vl_referencia"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="emolumento">* Emolumento:</label>
                                <input type="text" name="emolumento" value="{{ old('emolumento') ? old('emolumento') : $deedfee->emolumento }}" class="form-control" id="emolumento"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="selo">* Selo:</label>
                                <input type="text" name="selo" value="{{ old('selo') ? old('selo') : $deedfee->selo }}" class="form-control" id="selo"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="vl_total">* Valor total:</label>
                                <input type="text" name="vl_total" value="{{ old('vl_total') ? old('vl_total') : $deedfee->vl_total }}" class="form-control" id="vl_total"  placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
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
