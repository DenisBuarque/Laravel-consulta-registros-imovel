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
                Cálculo cessão de posse
                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('consultations.possession.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group">
                            <label for="venal_value">Informe o valor venal do imóvel:</label>
                            <input type="text" name="venal_value" value="{{ old('venal_value') ? old('venal_value') : '' }}" class="form-control" id="venal_value" placeholder="0,00" onkeyup="moeda(this);" maxlength="15">
                            @if ($errors->has('venal_value'))
                                <span class="help-block">
                                    <small class="form-text text-muted text-danger">{{ $errors->first('venal_value') }}</small>
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
