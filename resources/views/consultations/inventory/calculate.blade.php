@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Resultado <a href="{{ route('consultations.inventory.index') }}" title="">Consulta Custas Inventário</a> Imóvel
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
                                <td>Valor venal do imóvel:</td>
                                <td class="text-right">{{ number_format($venal_value,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Honorários Advogado(a)</td>
                                <td class="text-right">{{ number_format($fees,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Valor UFESP</td>
                                <td class="text-right">{{ number_format($ufesp,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Custa inventário judicial do imóvel</td>
                                <td class="text-right">{{ number_format($custas,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Honorários despachante</td>
                                <td class="text-right">{{ number_format($agent,2,',','.') }}</td>
                            </tr>
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Valor total</strong></td>
                                <td class="text-right"><strong>{{ number_format($payment,2,',','.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
