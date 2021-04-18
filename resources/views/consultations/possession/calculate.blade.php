@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Resultado <a href="{{ route('consultations.possession.index') }}">cálculo cessão de posse</a> 
                </div>

                <div class="panel-body">
                    
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="text-center">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Valor venal do imóvel</td>
                                <td class="text-right">{{ number_format($venal_value,2,'.',',') }}</td>
                            </tr>
                            <tr>
                                <td>Escritura</td>
                                <td class="text-right">{{ number_format($deed_fee,2,'.',',') }}</td>
                            </tr>
                            <tr>
                                <td>Honorários do despachante</td>
                                <td class="text-right">{{ number_format($fees,2,'.',',') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Valor Total</strong></td>
                                <td class="text-right"><strong>{{ number_format($total_value,2,'.',',') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
