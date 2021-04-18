@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

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
                    <div class='row'>
                        <div class='col-md-4'>
                            Detalhe do documento:
                        </div>
                        <div class='col-md-2'>
                            <a href="{{ route('certificates.index') }}" class="pull-right">Listar registros</a>
                        </div>
                        <div class='col-md-2'>
                            @can('generate-pdf')
                                <a href="{{ route('certificates.pdfcertificate', [$certificate->id, 'minuta']) }}" target='_blank' class="pull-right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    Minuta
                                </a>
                            @endcan
                        </div>
                        <div class='col-md-2'>
                            @can('generate-pdf')
                                <a href="{{ route('certificates.pdfcertificate', [$certificate->id, 'contract']) }}" target='_blank' class="pull-right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    Contrato
                                </a>
                            @endcan
                        </div>
                        <div class='col-md-2'>
                            @can('generate-pdf')
                                <a href="{{ route('certificates.pdfcertificate', [$certificate->id, 'letter']) }}" target='_blank' class="pull-right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    Procuração
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                @php
                    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                    date_default_timezone_set('America/Sao_Paulo');
                    $date = date('Y-m-d');
                    $day = strftime("%d", strtotime($date));
                    $month = strftime("%B", strtotime($date));
                    $year = strftime("%Y", strtotime($date));

                    $array = array('1' => 'solteiro(a)','2' => 'casado(a)','3' => 'divorciado(a)','4' => 'viúvo(a)');
                    $state_civil_buyer = '';
                    
                    foreach($array as $key => $vl2){
                        if($certificate->client->civil_state == $key){
                            $state_civil_buyer = $vl2;
                        }
                    }

                    $array_imovels = array('1' => 'Casa','2' => 'Terreno','3' => 'Lotemaneto','4' => 'Edifícil','5' => 'Sitío','6' => 'Chácara','7' => 'Fazenda');
                    $tipo = '';
                    foreach($array_imovels as $key => $item){
                        if($certificate->imovel->type_imovel == $key){
                            $tipo .= $item;
                        }
                    }
                @endphp

                    <h3 class="text-center">Ilustríssimo Senhor Oficial de Registro de Imóveis</h3>
                    
                    <p style="text-align: justify;">
                        Ao(s) @php echo $day @endphp dias(s) do mês de @php echo $month @endphp do ano de @php echo $year @endphp 
                        nesta cidade de Maceió, Capital do Estado de Alagoas, da República Federativa do Brasil. Eu  
                        
                        <strong>
                        @if(!empty($certificate->client->company))
                            {{ $certificate->client->company }}, CNPJ {{ $certificate->client->cnpj }}, 
                        @else
                            {{ $certificate->client->name }}, {{ $certificate->client->profession }},
                            portador da carteira da cédula de identidade de nº 
                            {{ $certificate->client->rg }} {{ $certificate->client->ssp }}, 
                            inscrito no CPF sob nº  {{ $certificate->client->cpf }},
                        @endif

                        residente no(a) {{ $certificate->client->address }}, 
                        nº {{ $certificate->client->number }}, 
                        {{ $certificate->client->district }}, 
                        {{ $certificate->client->city }}/{{ $certificate->client->state }}.
                    </strong>
                        A parte, qualificada, requer, a Vossa Senhoria, que seja(m) efetuado(s) o(s) 
                        ato(s) o(s) descritos(s) a SOLICITAÇÃO: 
                    <strong>
                        @php
                            $array_certificate = array(
                                '1' => 'Certidão de ônus',
                                '2' => 'Certidão de inteiro teor',
                                '3' => 'Certidão vintenária',
                                '4' => 'Certidão cinquentenária',
                                '5' => 'Certidão de escritura',
                                '6' => 'Certidão de procuração'
                            );

                            foreach($array_certificate as $key => $value){
                                if($certificate->certificate == $key){
                                    echo $value.' do ';
                                }
                            }

                            $array_registry = array(
                                '1' => 'Cartório de notas',
                                '2' => 'Cartório de registros'
                            );

                            foreach($array_registry as $key => $value){
                                if($certificate->registry == $key){
                                    echo $value.' do ';
                                }
                            }
                            
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

                            foreach($array_craft as $key => $value){
                                if($certificate->registry == $key){
                                    echo $value.' ';
                                }
                            }
                        
                            
                        @endphp
                        </strong>
                        do imóvel @php echo '<strong>'.$tipo.'</strong>' @endphp localizado na(o) endereço 
                        <strong>
                        @php
                            $array_imovels = array(
                                '1' => 'Casa',
                                '2' => 'Terreno',
                                '3' => 'Lotemaneto',
                                '4' => 'Edifícil',
                                '5' => 'Sitío',
                                '6' => 'Chácara',
                                '7' => 'Fazenda'
                            );
                            $tipo = '';
                            foreach($array_imovels as $key => $item){
                                if($certificate->imovel->type_imovel == $key){
                                    $tipo .= $item;
                                }
                            }
                        @endphp

                        {{ $certificate->imovel->address }}, 
                        nº {{ $certificate->imovel->number }}, 
                        {{ $certificate->imovel->district }} - 
                        {{ $certificate->imovel->city }}/{{ $certificate->imovel->state }}

                        @if($certificate->registry == 1)

                            @if(isset($certificate->book))
                                , livro de registro nº {{ $certificate->book }}
                            @endif
                            @if(isset($certificate->sheet))
                                , folha nº {{ $certificate->sheet }}
                            @endif
                            @if(isset($certificate->transcription))
                                , transcrição {{ $certificate->transcription }}
                            @endif
                            @if(isset($certificate->transcription))
                                , data do registro {{ $certificate->date_registry }}
                            @endif

                        @endif

                        @if(isset($certificate->imovel->iptu))
                            , IPTU {{ $certificate->imovel->iptu }}
                        @endif
                        @if(isset($certificate->imovel->registration))
                            , nº de registro {{ $certificate->imovel->registration }}
                        @endif
                        @if(isset($certificate->imovel->rip))
                            , RIP {{ $certificate->imovel->rip }}
                        @endif
                        @if(isset($certificate->imovel->name_allotment))
                            , loteamento {{ $certificate->imovel->name_allotment }}
                        @endif
                        @if(isset($certificate->imovel->number_allotment))
                            , nº loteamento {{ $certificate->imovel->number_allotment }}
                        @endif
                        @if(isset($certificate->imovel->block_allotment))
                            , quadra {{ $certificate->imovel->block_allotment }}
                        @endif
                        @if(isset($certificate->imovel->name_building))
                            , edifícil {{ $certificate->imovel->name_building }}
                        @endif
                        @if(isset($certificate->imovel->number_block))
                            , bloco {{ $certificate->imovel->number_block }}
                        @endif
                        @if(isset($certificate->imovel->number_apartment))
                            , apt° {{ $certificate->imovel->number_apartment }}
                        @endif
                        @if(isset($certificate->imovel->ccir))
                            , CCIR {{ $certificate->imovel->ccir }}
                        @endif
                        @if(isset($certificate->imovel->itr))
                            , ITR {{ $certificate->imovel->itr }}
                        @endif
                        @if(isset($certificate->imovel->incra))
                            , INCRA {{ $certificate->imovel->incra }}
                        @endif
                        @if(isset($certificate->imovel->name_farm))
                            , {{ $certificate->imovel->name_farm }}
                        @endif
                        @if(isset($certificate->imovel->latitude))
                            , latitude {{ $certificate->imovel->latitude }}
                        @endif
                        @if(isset($certificate->imovel->latitude))
                            , longitude {{ $certificate->imovel->latitude }}
                        @endif
                        .
                        @if(isset($certificate->description))
                            {{ $certificate->description }}.
                        @endif
                        </strong>
                    </p>
                    <hr>
                    <div class="row">
                        @foreach($certificate_images as $key => $images)
                            @if($images->certificate_id == $certificate->id)
                                <form method="POST" action="{{ route('certificates.imagedelete',$images->id) }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="col-md-4">
                                        <img src="../../certificates/{{ $certificate->id }}/{{ $images->path }}" class="img-thumbnail">
                                        <button type="submit" class="btn btn-xs btn-default" style="margin: 10px 0;">Excluir</button>
                                    </div>
                                </form>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
