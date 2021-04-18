@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Resultado <a href="{{ route('consultations.tranfer.finance.index') }}" title="Clique para acesssar o formulário de consulta financiado.">Consulta Financiamento</a> Imóvel /
                    <a href="{{ route('consultations.transfer.incash.index') }}" title="Clique para acesssar o formulário de consulta transferência.">Transferência</a>
                </div>

                <div class="panel-body">

                    @php
                        // Calculo de juros compostas
                        $valor_inicial =  $investiment_value;
                        $meses =  $portion;
                        $taxa_de_juros = 4;
                        $investimento_acumulado = $valor_inicial;
                        $juros_compostos_total = 0;
                        for ($i = 0; $i < $meses; $i++) {
                            $juros_compostos = ($investimento_acumulado * $taxa_de_juros) / 100;
                            $juros_compostos_total += $juros_compostos;
                            $investimento_acumulado += $juros_compostos;
                        }
                    @endphp
                    
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
                                <td class="text-right">{{ number_format($venal_value, 2,',','.') }}</td>
                            </tr>
                            @if($iptu_debit != 0)
                                <tr>
                                    <td>Débito IPTU</td>
                                    <td class="text-right">{{ number_format($iptu_debit, 2,',','.') }}</td>
                                </tr>
                            @endif
                            @if($debit_condominium != 0)
                                <tr>
                                    <td>Débito condomínio</td>
                                    <td class="text-right">{{ number_format($debit_condominium, 2,',','.') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Escritura do Imóvel</td>
                                <td class="text-right">{{ number_format($deed_fee,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>ITBI</td>
                                <td class="text-right">{{ number_format($itbi_value, 2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Registro do Imóvel</td>
                                <td class="text-right">{{ number_format($registration_fee, 2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Certidão de Ônus</td>
                                <td class="text-right">{{ number_format($onus_certificate,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Honorários Despachante</td>
                                <td class="text-right">{{ number_format($fees,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Valor total</strong></td>
                                <td class="text-right"><strong>{{ number_format( $investiment_value,2,',','.') }}</strong></td>
                            </tr>
                            <tr>
                                <td>
                                    Parcelas <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="Clique para listar as parcelas de juros do financimento.">Visualizar</a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                        <br>
                                            <div class="row">
                                                @php
                                                    $count = 1;
                                                    $juros_total = 0;
                                                    for ($i = 0; $i < $meses; $i++) {
                                                        $juros = ($valor_inicial * $taxa_de_juros) / 100;
                                                        $juros_total += $juros;
                                                        $valor_inicial += $juros;
                                                        echo "<div class='col-md-1'>".$count++."º</div>
                                                            <div class='col-md-11'>R$ ".number_format($juros,2,',','.')."</div>";
                                                    }
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right">{{ $portion }}</td>
                            </tr>
                            <tr>
                                <td>Total do juros</td>
                                <td class="text-right">{{ number_format($juros_compostos_total, 2, ",", ".") }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right"><strong>Total do investimento</strong></td>
                                <td class="text-right"><strong>{{ number_format($investimento_acumulado,2,',','.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>

                    <a class="pull-right" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Adicionar consulta de taxas</a>
                    <br>
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <form method="POST" action="{{ route('tenders.store') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <input type="hidden" name="venal_value" value="{{ $venal_value }}"/>
                                        <input type="hidden" name="iptu" value="{{ $iptu_debit }}"/>
                                        <input type="hidden" name="condominium" value="{{ $debit_condominium }}"/>
                                        <input type="hidden" name="portion" value="{{ $portion }}"/>
                                        <input type="hidden" name="fees" value="{{ $juros_compostos_total }}"/>
                                        <input type="hidden" name="deed_fee" value="{{ $deed_fee }}"/>
                                        <input type="hidden" name="itbi" value="{{ $itbi_value }}"/>
                                        <input type="hidden" name="registration_fee" value="{{ $registration_fee }}"/>
                                        <input type="hidden" name="certificaty" value="{{ $onus_certificate }}"/>
                                        <input type="hidden" name="letter" value="{{ $fees }}"/>
                                        <input type="hidden" name="total_value" value="{{ $investimento_acumulado }}"/>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>* Cliente:</label> 
                                        <select name="client_id" class="form-control">
                                            <option value=''></option>
                                            @foreach($clients as $key => $value)
                                                @if(!empty($value->company))
                                                    <option value="{{ $value->id }}">{{ $value->company }}</option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Imóvel:</label>
                                        <select name="imovel_id" class="form-control">
                                            <option value=''></option>
                                            @foreach($imovels as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->address }}, nº {{ $value->number }}, {{ $value->district }}, {{ $value->city }}/{{ $value->state }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success pull-right">Salvar Consulta de taxas</button>  
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
