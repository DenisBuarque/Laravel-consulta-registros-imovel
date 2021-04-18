@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif

            @if (session('erro'))
                <div class="alert alert-danger">
                    {{ session('erro') }}
                </div>
            @endif
            <div class="m-b-form-search">
                <form method="GET" action="{{ route('tenders.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <select name='search' class='form-control' require>
                            <option value=''>Selecione um ator</option>
                            @foreach($clients as $key => $value)
                                @if(!empty($value->company))
                                    <option value='{{ $value->id }}'>{{ $value->company }}</option>
                                @else
                                    <option value='{{ $value->id }}'>{{ $value->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('tenders.index') }}">Lista de Propostas</a> cadastrados
                    @can('create-data')
                        <a href="{{ route('consultations.transfer.incash.index') }}" class="pull-right">Adicionar Registro</a>
                    @endcan
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Valor venal</th>
                                    <th scope="col">IPTU</th>
                                    <th scope="col">Cond.</th>
                                    <th scope="col">Escritura</th>
                                    <th scope="col">ITBI</th>
                                    <th scope="col">Registro</th>
                                    <th scope="col">Honorários</th>
                                    <th scope="col">Juros</th>
                                    <th scope="col">Total</th>
                                    <th scope="col" class="text-center actionsButton">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tenders as $key => $value)
                                    <tr>
                                        <td>
                                            @if(!empty($value->company))
                                                {{ $value->client->company }}
                                            @else
                                                {{ $value->client->name }}
                                            @endif
                                        </td>
                                        <td>{{ number_format($value->venal_value,2,',','.') }}</td>
                                        <td>{{ number_format($value->iptu,2,',','.') }}</td>
                                        <td>{{ number_format($value->condominium,2,',','.') }}</td>
                                        <td>{{ number_format($value->deed_fee,2,',','.') }}</td>
                                        <td>{{ number_format($value->itbi,2,',','.') }}</td>
                                        <td>{{ number_format($value->registration_fee,2,',','.') }}</td>
                                        <td>{{ number_format($value->letter,2,',','.') }}</td>
                                        <td class="text-center">
                                            @if(!empty($value->portion))
                                                (x{{ $value->portion }}) {{ number_format($value->fees,2,',','.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ number_format($value->total_value,2,',','.') }}</td>
                                        <td class="text-center">
                                            @can('show-data')
                                                <a href="{{ route('tenders.pdf',$value->id) }}" target="_blank" class="btn btn-xs btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                </a>
                                            @endcan
                                            @can('delete-data')
                                                <a href="" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#ModalCentralizado{{ $value->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">Nenhum registro encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(!$search && $tenders) 
                        <div class="">{{ $tenders->links() }}</div>
                    @endif

                    @foreach($tenders as $value)
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-sm" id="ModalCentralizado{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TituloModalCentralizado">Deseja mesmo apagar o registro?</h5>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('tender.delete', $value->id) }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <button type="submit" class="btn btn-md btn-block btn-danger">
                                                Excluir registro
                                            </button>
                                        </form>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Não obrigado!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
