@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Resultado <a href="{{ route('consultations.declaration.index') }}">Cálculo declaração</a> de posse
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
                                <td>Declaração</td>
                                <td class="text-right">500,00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Valor Total</strong></td>
                                <td class="text-right"><strong>500,00</strong></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
