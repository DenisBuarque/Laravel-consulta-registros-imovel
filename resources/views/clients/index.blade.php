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
                <form method="GET" action="{{ route('clients.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search"value="{{ $search }}" required class="form-control" placeholder="Digite o nome...">
                        </div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                            <a href="{{ route('clients.index') }}">Lista de Atores</a> cadastrados
                        </div>
                        <div class="col-md-2">
                            @can('create-data')
                                <a href="{{ route('clients.fisic.create') }}">Adic. Pessoa Física</a>
                            @endcan
                        </div>
                        <div class="col-md-2">
                            @can('create-data')
                                <a href="{{ route('clients.juridic.create') }}">Adic. Pessoa Jurídica</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Tipo</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Endereço</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $key => $value)
                                <tr>
                                    <td>{{ $value->people }}</td>
                                    <td>
                                        @if(!empty($value->company))
                                            {{ $value->company }}
                                        @else
                                            {{ $value->name }}
                                        @endif
                                    </td>
                                    <td>{{ $value->phone }}</td>
                                    
                                    <td>{{ $value->address }}, {{ $value->number }}, {{ $value->district }}, {{ $value->city }}/{{ $value->state }}</td>
                                    <td class="text-center">
                                        @can('show-data')
                                            <a href="{{ route('clients.show', $value->id) }}" class="btn btn-xs btn-default">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            </a>
                                        @endcan
                                        @can('update-data')
                                            @if($value->people == "PF")
                                                <a href="{{ route('clients.fisic.edit', $value->id) }}" class="btn btn-xs btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </a>
                                            @else
                                                <a href="{{ route('clients.juridic.edit', $value->id) }}" class="btn btn-xs btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </a>
                                            @endif
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
                                    <td colspan="5">Nenhum registro encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if(!$search && $clients) 
                        <div class="">{{ $clients->links() }}</div>
                    @endif

                    @foreach($clients as $value)
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-sm" id="ModalCentralizado{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TituloModalCentralizado">Deseja mesmo apagar o registro?</h5>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('clients.delete', $value->id) }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <button type="submit" class="btn btn-md btn-danger btn-block">
                                                Apagar Registro
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
