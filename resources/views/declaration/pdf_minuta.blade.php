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
        foreach($array as $key => $vl2){
            if($declaration->client->civil_state == $key){
                $state_civil_buyer = $vl2;
            }
        }

        $array_imovels = array('1' => 'Casa','2' => 'Terreno','3' => 'Lotemaneto','4' => 'Edifícil','5' => 'Sitío','6' => 'Chácara','7' => 'Fazenda');
        $tipo = '';
        foreach($array_imovels as $key => $item){
            if($declaration->imovel->type_imovel == $key){
                $tipo .= $item;
            }
        }
    @endphp

    @if($declaration->tipo == 'D')
        <h3 class='text-center'>DECLARAÇÃO DE POSSE</h3>
    @else
        <h3 class='text-center'>CESSÃO DE POSSE</h3>
    @endif

    <p style="text-align: justify;">

    Eu, 
    <strong>{{ $declaration->client->name }}, {{ $declaration->client->profession }},
    portador da carteira da cédula de identidade de nº {{ $declaration->client->rg }} {{ $declaration->client->ssp }},
    inscrito no CPF sob nº {{ $declaration->client->cpf }}, @php echo $state_civil_buyer @endphp, residente no(a)
    {{ $declaration->client->address }}, nº {{ $declaration->client->number }}, {{ $declaration->client->district }}, 
    {{ $declaration->client->city }}/{{ $declaration->client->state }}.</strong>

    @if(isset($declaration->witness_1))
        E como TESTEMUNHA(S): 
        @if(isset($declaration->witness_1) || isset($declaration->witness_2))
            <strong>{{ $declaration->witnessOne->name }}, {{ $declaration->witnessOne->profession }}, portador da carteira da cédula de identidade de 
            nº {{ $declaration->witnessOne->rg }}/{{ $declaration->witnessOne->ssp }},
            inscrito no CPF sob nº {{ $declaration->witnessOne->cpf }}, 
            residente no(a) {{ $declaration->witnessOne->address }}, nº {{ $declaration->witnessOne->number }}, {{ $declaration->witnessOne->district }},  
            {{ $declaration->witnessOne->city }}/{{ $declaration->witnessOne->state }} </strong>
        @endif
        @if(isset($declaration->witness_2))
            <strong>e {{ $declaration->witnessTwo->name }}, {{ $declaration->witnessTwo->profession }}, portador da carteira da cédula de identidade de 
            nº {{ $declaration->witnessTwo->rg }}/{{ $declaration->witnessTwo->ssp }},
            inscrito no CPF sob nº {{ $declaration->witnessTwo->cpf }}, 
            residente no(a) {{ $declaration->witnessTwo->address }}, nº {{ $declaration->witnessTwo->number }}, {{ $declaration->witnessTwo->district }},  
            {{ $declaration->witnessTwo->city }}/{{ $declaration->witnessTwo->state }}.</strong>
        @endif
    @endif

    Declaro sob a penalidade prevista no artigo 299, do Código Penal Brasileiro (“Omitir,
    em documento público ou particular, declaração que dele devia constar, ou nele inserir ou
    fazer inserir declaração falsa ou diversa da que deveria ser inscrita, com o fim de prejudicar
    direito, criar obrigação ou alterar a verdade sobre o fato juridicamente relevante”) que
    ocupo e detenho a posse, justa e de boa-fé, a mais de 5(anos) do imóvel 
    <strong>{{ $tipo }}</strong>, localizado no endereço 

    <strong>
        {{ $declaration->imovel->address }}, 
        nº {{ $declaration->imovel->number }}, 
        {{ $declaration->imovel->district }} - 
        {{ $declaration->imovel->city }}/
        {{ $declaration->imovel->state }} com 

        {{ $declaration->living_room }} sala(s), 
        {{ $declaration->bedroom }} quarto(s), 
        {{ $declaration->kitchen }} cozinha(s), 
        {{ $declaration->bathroom }} banheiro(s), 
        {{ $declaration->garage }} garagem(s), 
        {{ $declaration->service_area }} área de serviço,  
        área de serviço {{ $declaration->service_area }}, 
        área total de frente {{ $declaration->front_area }}, 
        área totla de fundos {{ $declaration->funds_area }}, 
        área total a esquerda {{ $declaration->left_area }}, 
        área total a direita {{ $declaration->right_area }}, 
        área total construida {{ $declaration->building_area }}, 
        área total do terreno {{ $declaration->ground_area }}, 
        @if(isset($declaration->confront_front))
            {{ $declaration->confront_front }},
        @endif
        @if(isset($declaration->confront_right))
            {{ $declaration->confront_right }},
        @endif
        @if(isset($declaration->confront_left))
            {{ $declaration->confront_left }}, 
        @endif
        @if(isset($declaration->confront_funds))
            {{ $declaration->confront_funds }}, 
        @endif

        @if(isset($declaration->imovel->iptu))
            , IPTU {{ $declaration->imovel->iptu }}
        @endif
        @if(isset($declaration->imovel->registration))
            , nº de registro {{ $declaration->imovel->registration }}
        @endif
        @if(isset($declaration->imovel->rip))
            , RIP {{ $declaration->imovel->rip }}
        @endif
        @if(isset($declaration->imovel->name_allotment))
            , loteamento {{ $declaration->imovel->name_allotment }}
        @endif
        @if(isset($declaration->imovel->number_allotment))
            , nº loteamento {{ $declaration->imovel->number_allotment }}
        @endif
        @if(isset($declaration->imovel->block_allotment))
            , quadra {{ $declaration->imovel->block_allotment }}
        @endif
        @if(isset($declaration->imovel->name_building))
            , edifícil {{ $declaration->imovel->name_building }}
        @endif
        @if(isset($declaration->imovel->number_block))
            , bloco {{ $declaration->imovel->number_block }}
        @endif
        @if(isset($declaration->imovel->number_apartment))
            , apt° {{ $declaration->imovel->number_apartment }}
        @endif
        @if(isset($declaration->imovel->ccir))
            , CCIR {{ $declaration->imovel->ccir }}
        @endif
        @if(isset($declaration->imovel->itr))
            , ITR {{ $declaration->imovel->itr }}
        @endif
        @if(isset($declaration->imovel->incra))
            , INCRA {{ $declaration->imovel->incra }}
        @endif
        @if(isset($declaration->imovel->name_farm))
            , {{ $declaration->imovel->name_farm }}
        @endif
        @if(isset($declaration->imovel->latitude))
            , latitude {{ $declaration->imovel->latitude }}
        @endif
        @if(isset($declaration->imovel->latitude))
            , longitude {{ $declaration->imovel->latitude }}
        @endif
    </strong>

        e nesta forma e condições
        vem respeitosamente, solicitar a V.Sa., que se digne conceder-lhe a devida
        ANOTAÇÃO DE DADOS, NO CADASTRO IMOBILIÁRIO MUNICIPAL, referentes ao
        imóvel e contribuinte informados. Declaro, estar ciente que o deferimento deste pedido
        tem efeitos estritamente tributários, não criando direitos de propriedade ou de domínio,
        bem como não exclui o direito da administração pública de promover a adequação do
        imóvel às normas legais, sem prejuízo de outras medidas cabíveis.
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
        <small>Ortogante</small>
    </div>
    @if(isset($declaration->witness_1))
        <div class='signature'>
            <small>Testemunha</small>
        </div>
    @endif
    @if(isset($declaration->witness_2))
        <div class='signature'>
            <small>Testemunha</small>
        </div>
    @endif

</body>
</html>