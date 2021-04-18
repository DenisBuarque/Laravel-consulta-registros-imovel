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

    <h3>DECLARAÇÃO CESSÃO</h3>

    <p><strong>CONTRATANTE:</strong>
        @if(!empty($declaration->client->company))
            {{ $declaration->client->company }}, CNPJ {{ $declaration->client->cnpj }}, 
        @else
            {{ $declaration->client->name }}, {{ $declaration->client->profession }}, 
            portador da carteira da cédula de identidade de nº 
            {{ $declaration->client->rg }} {{ $declaration->client->ssp }},
            inscrito no CPF sob nº {{ $declaration->client->cpf }},
        @endif
        
        residente no(a) {{ $declaration->client->address }}, 
        nº {{ $declaration->client->number }}, 
        {{ $declaration->client->district }}, 
        {{ $declaration->client->city }}/{{ $declaration->client->state }}.
    </p>

    <p><strong>CONTRATADA:</strong>
        REGULARIZA IMÓVEIS LTDA, com sede nesta capital, na Tv. Juca Sampaio, nº 202,
        Barro Duro, inscrita no CNPJ sob o nº 10.347.372/0001-42, aqui representada por seu sócio, administrador,
        SEVERINO SILVIO DOS SANTOS LUZ, brasileiro, divorciado, empresário, portador da carteira da cédula de
        identidade nº 98001041976/SSP-Al, inscrito no CPF sob nº 923.835.134-15, residente e domiciliado nesta
        capital. As partes acima, nomeadas e qualificadas, por seus representantes legais abaixo assinados, têm
        entre si, justo e acertado, o presente Contrato de Prestação de Serviços que se regerá pelas cláusulas e
        condições a seguir expostas:
    </p>

    <p><strong>CLÁUSULA PRIMEIRA</strong>: 
        O objeto do presente instrumento particular é a prestação dos serviços de
        assessoria objetivando a regularização do imóvel de propriedade da CONTRATANTE situado nesta 
        capital, localizado no endereço {{ $declaration->client->address }}, 
        nº {{ $declaration->client->number }}, {{ $declaration->client->district }}, 
        {{ $declaration->client->city }}/{{ $declaration->client->state }}, 
        requerendo a CONTRATADA perante a municipalidade, em especial junto a SMCCU Secretaria Municipal
        de Controle e Convívio Urbano, protocolando e acompanhando o processo até o seu final, com a
        consequente expedição do alvará de construção/reforma do imóvel acima mencionado.
    </p>

    <p>
        <strong>CLÁUSULA SEGUNDA: O CONTRATADO </strong>
        declara, para os devidos fins e efeitos de direito, estar apta ao
        cumprimento das obrigações ora avençadas, os quais serão prestados com total observância à legislação
        vigente, nos âmbitos federal, estadual e municipal, sob pena de responsabilidade civil e criminal, sempre
        em caráter exclusivo.
    </p>

    <p>
        <strong>CLÁUSULA TERCEIRA:</strong>
        Pela execução dos serviços descritos na cláusula primeira acima, a CONTRATANTE
        pagará ao CONTRATADO a importância total, fixa e irreajustável, declarado em documento aparte.
    </p>

    <p>
        <strong>CLÁUSULA QUARTA:</strong>
        O presente contrato vigerá pelo prazo que for necessário para a conclusão dos
        serviços especificados na cláusula primeira.
    </p>

    <p>
        <strong>CLÁUSULA QUINTA: </strong>
        Este Contrato não implica em qualquer forma de associação ou solidariedade ativa
        ou passiva entre as Partes que permanecem única e exclusivamente responsáveis por suas obrigações de
        natureza fiscal, trabalhista, previdenciária ou cível. O CONTRATADO reconhece que a assinatura deste
        Contrato não implica na existência de nenhum vínculo ou encargo de qualquer espécie, incluindo
        trabalhistas ou previdenciários entre ele e as CONTRATANTES a qualquer título.
    </p>

    <p>
        <strong>CLÁUSULA SEXTA: </strong>
        O CONTRATADO não poderá ceder total ou parcialmente o presente contrato, a
        qualquer título, sem aprovação escrita da CONTRATANTE.
    </p>

    <p>
        <strong>CLÁUSULA SÉTIMA: </strong>
        Para dirimir as questões decorrentes do ajustado entre as partes, fica eleito o foro
        desta capital com renúncia expressa a qualquer outro, por mais privilegiado que seja.
        E, por estarem, assim, as partes justas e contratadas, firmam o presente instrumento em 02 (duas) vias,
        de igual teor e forma, para um só efeito, juntamente com as testemunhas instrumentárias ao final
        assinadas.
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
        <small>Contratante</small>
    </div>
    <div class='signature'>
        <small>Contratada</small>
    </div>

</body>
</html>