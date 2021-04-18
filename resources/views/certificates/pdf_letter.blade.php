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

        body h3 {
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
    <h3>PROCURAÇÃO</h3>
    <p><strong>Outogante: </strong>
        @if(!empty($certificate->client->company))
            {{ $certificate->client->company }}, CNPJ {{ $certificate->client->cnpj }}, 
        @else
            {{ $certificate->client->name }}, {{ $certificate->client->profession }}, 
            portador da carteira da cédula de identidade de nº 
            {{ $certificate->client->rg }} {{ $certificate->client->ssp }},
            inscrito no CPF sob nº {{ $certificate->client->cpf }},
        @endif
        
        residente no(a) {{ $certificate->client->address }}, 
        nº {{ $certificate->client->number }}, 
        {{ $certificate->client->district }}, 
        {{ $certificate->client->city }}/{{ $certificate->client->state }}.
    </p>

    <p><strong>Outorgado: </strong>
        REGULARIZA IMÓVEIS LTDA, com sede nesta capital, na Tv. Juca Sampaio, nº 202, Barro
        Duro, inscrita no CNPJ sob o nº 10.347.372/0001-42, aqui representada por seu sócio, administrador,
        SEVERINO SILVIO DOS SANTOS LUZ, brasileiro, divorciado, empresário, portador da carteira da cédula de
        identidade de nº 98001041976/SSP-AL, inscrito no CPF sob nº 923.835.134-15, residente e domiciliado
        nesta capital.
    </p>

    <p><strong>Poderes: </strong>
        A quem confere poderes para representar ao(a) outorgante junto aos CARTÓRIO DE NOTAS,
        CARTÓRIO DE REGISTROS, SECRETÁRIA MUNICIPAL DE FINANÇAS, ou em qualquer departamento público,
        com o fim especifico de resolver todo e qualquer assunto referente ao imóvel, localizado no(a) 
        {{ $certificate->client->address }}, nº {{ $certificate->client->number }},  
        {{ $certificate->client->district }}, {{ $certificate->client->city }}/{{ $certificate->client->state }}
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
        <small>Outogante</small>
    </div>
    <div class='signature'>
        <small>Outogado</small>
    </div>

</body>
</html>