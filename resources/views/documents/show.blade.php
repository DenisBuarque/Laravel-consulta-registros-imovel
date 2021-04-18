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
                        <div class='col-md-8'>
                            Detalhe do documento:
                        </div>
                        <div class='col-md-2'>
                            <a href="{{ route('documents.index') }}" class="pull-right">Listar registros</a>
                        </div>
                        <div class='col-md-2'>
                            <a href="{{ route('documents.pdf', $document->id) }}" target='_blank' class="pull-right">Gerar PDF</a>
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
                        $state_civil_seller = '';
                        $state_civil_buyer = '';
                        foreach($array as $key => $vl1){
                            if($document->sellers->civil_state == $key){
                                $state_civil_seller = $vl1;
                            }
                        }

                        foreach($array as $key => $vl2){
                            if($document->client->civil_state == $key){
                                $state_civil_buyer = $vl2;
                            }
                        }

                        $array_imovels = array('1' => 'Casa','2' => 'Terreno','3' => 'Lotemaneto','4' => 'Edifícil','5' => 'Sitío','6' => 'Chácara','7' => 'Fazenda');
                        $tipo = '';
                        foreach($array_imovels as $key => $item){
                            if($document->imovel->type_imovel == $key){
                                $tipo .= $item;
                            }
                        }
                    @endphp

                    <p style="text-align: justify;">
                        <strong>S A I B A M</strong> quantos este ato particular de escritura de Compra e Venda virem que aos @php echo $day @endphp dias(s) do mês
                        de @php echo $month @endphp do ano de @php echo $year @endphp nesta cidade de Maceió, Capital do Estado de Alagoas, da República Federativa do
                        Brasil, em meu escritório Particular, situado na Travessa Juca Sampaio,nº 202, Barro Duro, nesta cidade.
                    
                        De um lado como OUTORGANTE(S) VENDEDOR(ES): 
                        <strong>{{ $document->sellers->name }}, @if (isset($document->sellers->profession)) {{ $document->sellers->profession }}, @endif 
                        portador da carteira da cédula de identidade de nº {{ $document->sellers->rg }}/{{ $document->sellers->ssp }},
                        inscrito no CPF sob nº {{ $document->sellers->cpf }}, @php echo $state_civil_seller @endphp, residente no(a)
                        {{ $document->sellers->address }}, nº {{ $document->sellers->number }}, {{ $document->sellers->district }}, 
                        {{ $document->sellers->city }}/{{ $document->sellers->state }}.</strong>

                        E do outro lado como OUTORGADO(S) COMPRADOR(ES): 
                        <strong>{{ $document->client->name }}, @if (isset($document->client->profession)) {{ $document->client->profession }}, @endif 
                        portador da carteira da cédula de identidade de nº {{ $document->client->rg }}/{{ $document->client->ssp }},
                        inscrito no CPF sob nº {{ $document->client->cpf }}, @php echo $state_civil_buyer @endphp, residente no(a)
                        {{ $document->client->address }}, nº {{ $document->client->number }}, {{ $document->client->district }}, 
                        {{ $document->client->city }}/{{ $document->client->state }}.</strong>

                        @if(isset($document->witness_1))
                            E como TESTEMUNHA(S): 
                            @if(isset($document->witness_1) || isset($document->witness_2))
                                <strong>{{ $document->witnessOne->name }}, {{ $document->witnessOne->profession }}, portador da carteira da cédula de identidade de 
                                nº {{ $document->witnessOne->rg }}/{{ $document->witnessOne->ssp }},
                                inscrito no CPF sob nº {{ $document->witnessOne->cpf }}, 
                                residente no(a) {{ $document->witnessOne->address }}, nº {{ $document->witnessOne->number }}, {{ $document->witnessOne->district }},  
                                {{ $document->witnessOne->city }}/{{ $document->witnessOne->state }}.</strong>
                            @endif
                            @if(isset($document->witness_2))
                                <strong>{{ $document->witnessTwo->name }}, {{ $document->witnessTwo->profession }}, portador da carteira da cédula de identidade de 
                                nº {{ $document->witnessTwo->rg }}/{{ $document->witnessTwo->ssp }},
                                inscrito no CPF sob nº {{ $document->witnessTwo->cpf }}, 
                                residente no(a) {{ $document->witnessTwo->address }}, nº {{ $document->witnessTwo->number }}, {{ $document->witnessTwo->district }},  
                                {{ $document->witnessTwo->city }}/{{ $document->witnessTwo->state }}.</strong>
                            @endif
                        @endif

                        Pelo(s) Outorgante(s) Vendedor(es) me foi dito que a justo titulo é(são)
                        senhor(es) e legitimo(s) possuidor(es) do imóvel 
                        <strong>@php echo $tipo @endphp</strong>, localizado no endereço
                        <strong>
                            {{ $document->imovel->address }}, 
                            nº {{ $document->imovel->number }}, 
                            {{ $document->imovel->district }} - 
                            {{ $document->imovel->city }}/
                            {{ $document->imovel->state }}

                            @if(isset($document->imovel->iptu))
                                , IPTU {{ $document->imovel->iptu }}
                            @endif
                            @if(isset($document->imovel->registration))
                                , nº de registro {{ $document->imovel->registration }}
                            @endif
                            @if(isset($document->imovel->rip))
                                , RIP {{ $document->imovel->rip }}
                            @endif
                            @if(isset($document->imovel->name_allotment))
                                , loteamento {{ $document->imovel->name_allotment }}
                            @endif
                            @if(isset($document->imovel->number_allotment))
                                , nº loteamento {{ $document->imovel->number_allotment }}
                            @endif
                            @if(isset($document->imovel->block_allotment))
                                , quadra {{ $document->imovel->block_allotment }}
                            @endif
                            @if(isset($document->imovel->name_building))
                                , edifícil {{ $document->imovel->name_building }}
                            @endif
                            @if(isset($document->imovel->number_block))
                                , bloco {{ $document->imovel->number_block }}
                            @endif
                            @if(isset($document->imovel->number_apartment))
                                , apt° {{ $document->imovel->number_apartment }}
                            @endif
                            @if(isset($document->imovel->ccir))
                                , CCIR {{ $document->imovel->ccir }}
                            @endif
                            @if(isset($document->imovel->itr))
                                , ITR {{ $document->imovel->itr }}
                            @endif
                            @if(isset($document->imovel->incra))
                                , INCRA {{ $document->imovel->incra }}
                            @endif
                            @if(isset($document->imovel->name_farm))
                                , {{ $document->imovel->name_farm }}
                            @endif
                            @if(isset($document->imovel->latitude))
                                , latitude {{ $document->imovel->latitude }}
                            @endif
                            @if(isset($document->imovel->latitude))
                                , longitude {{ $document->imovel->latitude }}
                            @endif
                        </strong>

                        E pelo preço certo e ajustado de <strong>R$ {{ number_format($document->imovel->venal_value,2,'.',',') }}  
                        ( {!! app(App\Utils\UtilsRepositoryInterface::class)->extensionValueMoney($document->imovel->venal_value) !!} )</strong> 
                        que o(s) Outorgante(s) vendedor(es) confessa(m) e declara(m) haver recebido em moeda corrente brasileira, cujo preço lhe(s)
                        da(ao) plena e geral quitação, vende(m) ao(s) outorgado(s) comprador(es), como de fato vendido tem, o(s)
                        descrito(s) bem(ns), livre e desembaraçado de ônus, dívidas e litígios de quaisquer naturezas, 
                        obrigandose ele(s) outorgante(s) vendedor(es) a fazer(em) esta venda sempre boa, firme e valiosa e a
                        responder(em) pela evicção, quando chamado(s) a autoria, podendo o(s) outorgado(s) comprador(es),
                        empossar(em)se desde já do(s) bem(ns) vendido(s), pois ele(s) transfere(m) neste ato e pela cláusula
                        "constituti" todo o direito, domínio, ação e posse que sobre o(s) mesmo(s) vinha(m) exercendo. Então
                        pelo(s) outorgado(s) comprador(es), foi dito que aceitava(m) esta escritura em todos seus termos por se
                        achar a mesma de pleno acordo com o ajustado e contratado entre si e o(s) vendedor(es).
                    
                    </p>
                    <hr>
                    <div class="row">
                        @foreach($documents_images as $key => $images)
                            @if($images->document_id == $document->id)
                                <form method="POST" action="{{ route('documents.imagedelete',$images->id) }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="col-md-4">
                                        <img src="../../documents/{{ $document->id }}/{{ $images->path }}" class="img-thumbnail">
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
