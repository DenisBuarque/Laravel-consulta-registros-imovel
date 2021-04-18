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
                <form method="GET" action="{{ route('certificates.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            @php
                            $array_certificate = array(
                                '1' => 'Certidão de ônus',
                                '2' => 'Certidão de inteiro teor',
                                '3' => 'Certidão vintenária',
                                '4' => 'Certidão cinquentenária',
                                '5' => 'Certidão de escritura',
                                '6' => 'Certidão de procuração'
                            );
                            @endphp
                            <select name='search' class='form-control' require>
                                <option value=''>Selecione o tipo de certidão</option>
                                @foreach($array_certificate as $key => $value)
                                    <option value='{{ $key }}'>{{ $value }}</option>
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
                    <a href="{{ route('certificates.index') }}">Lista de Certidões</a> cadastradas
                    @can('create-data')
                        <a href="{{ route('certificates.create') }}" class="pull-right">Adicionar Registro</a>
                    @endcan
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Cartório</th>
                                    <th scope="col">Ofício</th>
                                    <th scope="col">Certidão</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col" class="text-center actionsButton">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $key => $value)
                                    <tr>
                                        <td>
                                            @php
                                                $array = array('1' => 'Cartório de registros','2' => 'Cartório de notas');
                                                foreach($array as $key => $registry){
                                                    if($value->registry == $key){
                                                        echo $registry;
                                                    }
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $array_craft = array(
                                                    '1' => '1º Registro de imóvel',
                                                    '2' => '2º Registro de imóvel',
                                                    '3' => '3º Registro de imóvel',
                                                    '4' => '1º Ofício',
                                                    '5' => '2º Ofício',
                                                    '6' => '3º Ofício',
                                                    '7' => '4º Ofício',
                                                    '8' => '5º Ofício',
                                                    '9' => '6º Ofício'
                                                );
                                                foreach($array_craft as $key => $craft){
                                                    if($value->certificate == $key){
                                                        echo $craft;
                                                    }
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $array = array('1' => 'Certidão de ônus','2' => 'Certidão de inteiro teor','3' => 'Certidão vintenária','4' => 'Certidão cinquentenária','5' => 'Certidão de escritura','6' => 'Certidão de procuração');
                                                foreach($array as $key => $actory){
                                                    if($value->certificate == $key){
                                                        echo $actory;
                                                    }
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                        @if(!empty($value->client->company))
                                            {{ $value->client->company }}
                                        @else
                                            {{ $value->client->name }}
                                        @endif
                                        </td>
                                        <td class="text-center">
                                            @can('show-data')
                                                <a href="{{ route('certificates.show',$value->id) }}" class="btn btn-xs btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                </a>
                                            @endcan
                                            @can('update-data')
                                                <a href="{{ route('certificates.edit', $value->id) }}" class="btn btn-xs btn-success">
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
                                        <td claspan="5">Nenhum registro encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(!$search && $certificates) 
                        <div class="">{{ $certificates->links() }}</div>
                    @endif

                    @foreach($certificates as $value)
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-sm" id="ModalCentralizado{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TituloModalCentralizado">Deseja mesmo apagar o registro?</h5>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('certificates.delete', $value->id) }}">
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
