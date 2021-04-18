@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

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
                Cálculo INSS da Construção/Obra
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('consultations.construction.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group">
                            <label for="area">Informe a área total do imóvel:</label>
                            <input type="text" name="area" value="{{ old('area') ? old('area') : '' }}" class="form-control" id="area" autofocus maxlength="10">
                            @if ($errors->has('area'))
                                <span class="help-block">
                                    <small class="form-text text-muted text-danger">{{ $errors->first('area') }}</small>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="cub">CUB:</label> <a href="http://www.cub.org.br/" target="_blank">Custo Unitário Básico</a> (m/2)
                            <input type="text" name="cub" value="{{ old('cub') ? old('cub') : '' }}" class="form-control" id="cub" placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            @if ($errors->has('cub'))
                                <span class="help-block">
                                    <small class="form-text text-muted text-danger">{{ $errors->first('cub') }}</small>
                                </span>
                            @endif
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
