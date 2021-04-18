@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @if (session('alert'))
                <div class="alert alert-success">
                    {{ session('alert') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                Detalhes do cadastro pessoa física
                <a href="{{ route('clients.index') }}" class="pull-right">Listar Registros</a>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3">Nome</div>
                        <div class="col-md-8">{{ $client->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">CPF</div>
                        <div class="col-md-8">{{ $client->cpf }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">RG</div>
                        <div class="col-md-8">{{ $client->rg }} {{ $client->ssp }}</div>
                    </div>

                    @if($client->people == "PF")
                        <div class="row">
                            <div class="col-md-3">Profissão</div>
                            <div class="col-md-8">{{ $client->profession }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Nacionalidade</div>
                            <div class="col-md-8">{{ $client->nationality }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Estado Civil</div>
                            <div class="col-md-8">
                                @php
                                    $options = array('1' => 'Solteiro', '2' => 'Casado', '3' => 'Divorciado', '4' => 'Viúvo');
                                    foreach($options as $key => $v){
                                        if($client->civil_state == $key){
                                            echo $v;
                                        }
                                    }
                                @endphp
                            </div>
                        </div>
                    @endif

                    @if($client->people == "PJ")
                        <div class="row">
                            <div class="col-md-3">Razão Social</div>
                            <div class="col-md-8">{{ $client->company }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">CNPJ</div>
                            <div class="col-md-8">{{ $client->cnpj }}</div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">Endereço</div>
                        <div class="col-md-8">{{ $client->address }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Nº</div>
                        <div class="col-md-8">{{ $client->number }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Bairro</div>
                        <div class="col-md-8">{{ $client->district }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Cidade / UF</div>
                        <div class="col-md-8">{{ $client->city }} / {{ $client->state }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Telefone</div>
                        <div class="col-md-8">{{ $client->phone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">E-mail</div>
                        <div class="col-md-8">{{ $client->email }}</div>
                    </div>
                    <br>
                    <a href="" class="btn btn-md btn-danger" data-toggle="modal" data-target="#ModalCentralizado{{ $client->id }}">Excluir registro</a> 
                    
                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-sm" id="ModalCentralizado{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="TituloModalCentralizado">Deseja mesmo apagar o registro?</h5>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('clients.delete', $client->id) }}">
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
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
