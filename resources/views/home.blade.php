@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Aplicação de consultas e relatórios de registros de imóvel:</strong></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                        <p>Consultas de taxas de registros:</p>
                            <ul>
                                @can('query-transfer')
                                    <li>Consultar <a href="{{ route('consultations.transfer.incash.index') }}">Transferêcia de imóveis.</a></li>
                                    <li>Consultar <a href="{{ route('consultations.tranfer.finance.index') }}">Transferêcia de imóvel financiado.</a></li>
                                @endcan
                                @can('query-building')
                                    <li>Consultar <a href="{{ route('consultations.construction.index') }}">construção ou obra.</a></li>
                                @endcan
                                @can('query-usucapiao')
                                    <li>Consultar <a href="{{ route('consultations.usucapiao.index') }}">usucapião.</a></li>
                                @endcan
                                @can('query-inventory')
                                    <li>Consultar <a href="{{ route('consultations.inventory.index') }}">inventário.</a></li>
                                @endcan
                                @can('query-declaration')
                                    <li>Consultar <a href="{{ route('consultations.declaration.index') }}">declaração de posse.</a></li>
                                @endcan
                                @can('query-possession')
                                    <li>Consultar <a href="{{ route('consultations.possession.index') }}">cessão de posse.</a></li>
                                @endcan
                            </ul>
                        </div>
                        <div class="col-md-6">
                        <p>Relatório de documentos:</p>
                            <ul>
                                @can('list-tender')
                                    <li>Listar <a href="{{ route('tenders.index') }}">propostas de serviços</a></li>
                                @endcan
                                @can('list-incra')
                                    <li>Listar <a href="{{ route('incra.index') }}">documentos do INCRA</a> (CCIR)</li>
                                @endcan
                                @can('generate-transfer')
                                    <li>Listar <a href="{{ route('documents.index') }}"> transferências</a> de imóveis.</li>
                                @endcan
                                @can('generate-certificate')
                                    <li>Listar <a href="{{ route('certificates.index') }}">solicitações de certidões.</a></li>
                                @endcan
                                @can('generate-declaration')
                                    <li>Listar <a href="{{ route('declaration.index') }}">declarações de posse</a> do imóvel.</li>
                                    <li>Listar <a href="{{ route('declaration.index') }}">cessões de posse</a> do imóvel.</li>
                                @endcan
                                @can('list-receipt')
                                    <li>Listar <a href="{{ route('receipt.index') }}">recibos emitidos.</a></li>
                                @endcan
                                @can('list-mail')
                                    <li>Enviar <a href="{{ route('receiptemail.create') }}">e-mail</a>.</li>
                                @endcan
                                @can('list-deed')
                                    <li>Listar <a href="{{ route('deedfee.index') }}">taxas de escrituras</a> (emolumentos)</li>
                                @endcan
                                @can('list-register')    
                                    <li>Listar <a href="{{ route('registrationfee.index') }}">taxas de registro</a> (emolumentos)</li>
                                @endcan
                            </ul>
                        </div>
                    </div>              
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
