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
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('registrationfee.index') }}">Lista de Taxas de registro</a> cadastrados
                    @can('create-data')
                        <a href="{{ route('registrationfee.create') }}" class="pull-right">Adicionar Registro</a>
                    @endcan
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Referência</th>
                                    <th scope="col" class="text-center">Emolumento</th>
                                    <th scope="col" class="text-center">Selo</th>
                                    <th scope="col" class="text-center">Total</th>
                                    <th scope="col" class="text-center actionsButton">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrationfees as $key => $value)
                                    <tr>
                                        <td class="text-center">{{ number_format($value->vl_ref,2,',','.') }}</td>
                                        <td class="text-center">{{ number_format($value->codigo,2,',','.') }}</td>
                                        <td class="text-center">{{ number_format($value->ate_valor,2,',','.') }}</td>
                                        <td class="text-center">{{ number_format($value->custo_total,2,',','.') }}</td>
                                    
                                        <td class="text-center">
                                            @can('update-data')
                                                <a href="{{ route('registrationfee.edit', $value->id) }}" class="btn btn-xs btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
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
                                        <td colspan="4">Nenhum registro encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($registrationfees) 
                        <div class="">{{ $registrationfees->links() }}</div>
                    @endif

                    @foreach($registrationfees as $value)
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-sm" id="ModalCentralizado{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TituloModalCentralizado">Deseja mesmo apagar o registro?</h5>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('registrationfee.delete', $value->id) }}">
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
