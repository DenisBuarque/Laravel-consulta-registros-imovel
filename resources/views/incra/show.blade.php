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
                            <a href="{{ route('incra.index') }}" class="pull-right">Listar registros</a>
                        </div>
                        <div class='col-md-2'>
                            <a href="{{ route('incra.pdf', $incra->id) }}" target='_blank' class="pull-right">Gerar PDF</a>
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
                        $state_civil = '';
                        foreach($array as $key => $value){
                            if($incra->client->civil_state == $key){
                                $state_civil = $value;
                            }
                        }
                    @endphp

                    <h3 class='text-center'>REQUERIMENTO AVERBAÇÃO DE CCIR</h3>
                    <p class='text-center'>ILMO. SR. OFICIAL DO REGISTRO GERAL DE IMÓVEIS DE MACEIÓ/AL</p>

                    <p>REPRESENTANTE:
                        <strong>REGULARIZA IMÓVEIS LTDA</strong>, com sede nesta capital, na <strong>Tv. Juca Sampaio, nº 202,
                        Barro Duro, inscrita no CNPJ sob o nº 10.347.372/0001-42</strong>, aqui representada por seu sócio, administrador,
                        <strong>SEVERINO SILVIO DOS SANTOS LUZ, brasileiro, divorciado, empresário, portador da carteira da cédula de
                        identidade nº 98001041976/SSP-Al, inscrito no CPF sob nº 923.835.134-15</strong>, residente e domiciliado nesta
                        capital. As partes acima, nomeadas e qualificadas, por seus representantes legais abaixo assinados, têm
                        entre si, justo e acertado, o presente Contrato de Prestação de Serviços que se regerá pelas cláusulas e
                        condições a seguir expostas:
                    </p>
                    
                    <p style="text-align: justify;">REQUERENTE: 
                    <strong>{{ $incra->client->name }}, @if (isset($incra->client->profession)) {{ $incra->client->profession }}, @endif 
                    portador da carteira da cédula de identidade de nº {{ $incra->client->rg }}/{{ $incra->client->ssp }},
                    inscrito no CPF sob nº {{ $incra->client->cpf }}, {{ $state_civil }}, residente no(a)
                    {{ $incra->client->address }}, nº {{ $incra->client->number }}, {{ $incra->client->district }}, 
                    {{ $incra->client->city }}/{{ $incra->client->state }},</strong> 

                    vem por meio deste, requerer a devida averbação no do Registro Geral de Imóvel de Maceió/AL, para constar o Certificado de Cadastro 
                    de Imóvel Rural – CCIR, do imóvel denominado <strong>{{ $incra->denominacao }}</strong>, indicado na localização <strong>{{ $incra->localization }}</strong>,
                    medindo uma área total <strong>{{ $incra->total_area }}</strong> ha, no municipio sede <strong>{{ $incra->county }}</strong>, 
                    @if(!$incra->zona)
                        localizada em zona urbana de <strong>{{ $incra->zona }}</strong> (ha), 
                    @endif
                    estado {{ $incra->state }}
                    @if(!empty($incra->latitude))
                        latitude <strong>{{ $incra->latitude }}</strong>, logitude  <strong>{{ $incra->longitude }}</strong>,
                    @endif
                    @php
                        $nature = array(
                            '1' => 'Assentamento',
                            '2' => 'Estrada',
                            '3' => 'Ferrovia',
                            '4' => 'Floresta Pública',
                            '5' => 'Gleba Pública',
                            '6' => 'Particular',
                            '7' => 'Perímetro Urbano',
                            '8' => 'Terra Indígena',
                            '9' => 'Terreno de Marinha',
                            '10' => 'Terreno Marginal',
                            '11' => 'Território Quilombola',
                            '12'=> 'Unidade de Conservação'
                        );
                    @endphp
                    @foreach($nature as $key => $value)
                        @if($incra->nature == $key)
                            natureza da área <strong>{{ $incra->nature }}</strong>,
                        @endif
                    @endforeach
                    @if(!empty($incra->division_country))
                        imóvel rural localiza em mais de um município <strong>{{ $incra->division_country }}</strong>,
                    @endif
                    com destinação {{ $incra->destiny }},
                    @if(!empty($incra->dismemberment_area))
                        total da área desmembrada <strong>{{ $incra->dismemberment_area }}</strong> (ha),
                    @endif
                    @if(!empty($incra->anexo_area))
                        total da área desmembrada <strong>{{ $incra->anexo_area }}</strong> (ha) imovel rural,
                    @endif
                    @if(!empty($incra->area_add))
                        total da área de remembramento NÃO cadastrado no imovel rural <strong>{{ $incra->area_add }}</strong>,
                    @endif
                    quantidade de famílias residentes <strong>{{ $incra->amount_family }}</strong>,
                    quantidade de pessoas residentes <strong>{{ $incra->amount_people }}</strong>, 
                    assalariados permanentes COM carteira assinada <strong>{{ $incra->salary_portfolio }}</strong>,
                    assalariados permanentes SEM carteira assinada <strong>{{ $incra->salary_not }}</strong>, 
                    mão de obra familiar <strong>{{ $incra->family_labor }}</strong>,
                    @if(!empty($incra->litigation))
                        litigios 
                        @php
                            $litigios = array(
                                '1' => 'Questão de limite',
                                '2' => 'Questão de titulação',
                                '3' => 'Questão quanto ao domínio',
                                '4' => 'Questão quanto a posse do domínio',
                                '5' => 'Questão quanto a posse',
                                '6' => 'Questão restrição use de terra',
                                '7' => 'Servidão do acesso',
                                '8' => 'Servidão do uso da água',
                                '9' => 'Árae com posseiros'
                            );
                            foreach($litigios as $key => $value){
                                if($key == $incra->litigation){
                                    echo '<strong>'.$value.'</strong>, ';
                                }
                            }
                        @endphp
                    @endif

                    @php
                        $improvements = array(
                            '1' => 'Benfeitoria',
                            '2' => 'Comércio',
                            '3' => 'Hotel fazenda',
                            '4' => 'Industria',
                            '5' => 'Mineração',
                            '6' => 'Olaria',
                            '7' => 'Pesque-pague',
                            '8' => 'Outros'
                        );
                        foreach($improvements as $key => $value){
                            if($key == $incra->improvement){
                                echo '<strong>'.$value.'</strong>, área utilizada <strong>'.$incra->used_area.'</strong>, ';
                            }
                        }
                    @endphp
                    
                    @if(!empty($incra->animal_category))
                        denominação animal <strong>{{ $incra->animal_category }}</strong>, 
                        quantidade de animais <strong>{{ $incra->amount_animal }}</strong>.
                    @endif
                        
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
