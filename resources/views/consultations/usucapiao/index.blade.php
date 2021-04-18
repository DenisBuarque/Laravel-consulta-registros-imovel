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
                <div class="panel-heading">Consulta Registro Usucapião</div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('consultations.usucapiao.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group">
                            <label for="valor">Informe o valor venal do imóvel:</label>
                            <input type="text" name="venal_value" value="{{ old('venal_value') ? old('venal_value') : '' }}" class="form-control is-invalid" id="valor" placeholder="0,00" autofocus onkeyup="moeda(this);" maxlength="15">
                            @if ($errors->has('venal_value'))
                                <span class="help-block">
                                    <small class="form-text text-muted text-danger">{{ $errors->first('venal_value') }}</small>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="fees">Honorários do Advogado de Usucapião:</label>
                            <input type="text" name="fees" value="{{ old('fees') ? old('fees') : '' }}" class="form-control" id="fees" placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            @if ($errors->has('fees'))
                                <span class="help-block">
                                    <small class="form-text text-muted text-danger">{{ $errors->first('fees') }}</small>
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
