<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document PDF</title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        h3 {
            text-align: center;
        }

        .signature{
            border-top: #000000 1px solid;
            text-align: center;
            padding: 10px;
            margin: 30px 150px;
        }

        .data {
            text-align: center;
            margin: 50px 0;
        }

        body p {
            text-align: justify;
        }
    </style>
</head>
<body>
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
    <p>
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
    
    @php
        $dia = date("d");
        $mes = date("n");
        $ano = date("Y");
        $mesext = array(1 => "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
        $diaext = array("Sun" => "Domingo", "Mon" => "Segunda", "Tue" => "Terçaa", "Wed" => "Quarta", "Thu" => "Quinta", "Fri" => "Sexta", "Sat" => "Sábado");
        echo "<p class='data'>Maceió, $dia dias(s) do mês de $mesext[$mes] do ano de $ano</p>";
    @endphp

    <div class='signature'>
        <small>Solicitante</small>
    </div>
    <div class='signature'>
        <small>Responsável pelo imóvel</small>
    </div>
    
</body>
</html>