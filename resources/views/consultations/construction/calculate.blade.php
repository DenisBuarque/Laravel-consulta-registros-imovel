@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Resultado <a href="{{ route('consultations.construction.index') }}" title="Clique para acesssar o formulário de cálculo INSS de construção.">Cálculo Regularização</a> Construção/Obra
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
                                <td>Área do imóvel</td>
                                <td class="text-right">{{ $area }} m/2</td>
                            </tr>
                            <tr>
                                <td>CUB (valor m/2)</td>
                                <td class="text-right">{{ number_format($cub,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Valor base para cálculo</td>
                                <td class="text-right">{{ number_format($value_calculo_cub, 2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>+ INSS Patronal (20%)</td>
                                <td class="text-right">{{ number_format($inss_patrimonial, 2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>+ INSS Segurado (8%)</td>
                                <td class="text-right">{{ number_format($inss_segurado, 2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>+ RAT (3%)</td>
                                <td class="text-right">{{ number_format($rat, 2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>+ Outras Entidades (5.8%)</td>
                                <td class="text-right">{{ number_format($outros, 2,',','.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total total</strong></td>
                                <td class="text-right"><strong>{{ number_format($total_payment,2,',','.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
