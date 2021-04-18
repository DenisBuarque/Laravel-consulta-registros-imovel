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

    <h3>RECIBO</h3>
    <p>R$ {{ number_format($receipt->total_value,2,',','.') }}</p>
    <p>
        Recebei do(a) 
        @if(!empty($receipt->client->company))
            {{ $receipt->client->company }}, CNPJ {{ $receipt->client->cnpj }},
        @else
            {{ $receipt->client->name }}, CPF {{ $receipt->client->cpf }}, 
        @endif

        a importância no valor de R$ {{ $receipt->total_value }} 
        ( {!! app(App\Utils\UtilsRepositoryInterface::class)->extensionValueMoney($receipt->total_value) !!} )
        referente á certidões de pequisa do imóvel, localiado na(o) 

        {{ $receipt->client->address }}, nº {{ $receipt->client->number }}, {{ $receipt->client->district }}, 
        {{ $receipt->client->city }}/{{ $receipt->client->state }}.
        
        @if($receipt->client->phone)
            Informações para contato telefone {{ $receipt->client->phone }}. 
        @endif
        @if($receipt->client->email)
            E-mail {{ $receipt->client->email }}.
        @endif
    </p>

    @php
        $array_imovels = array('1' => 'Casa','2' => 'Terreno','3' => 'Lotemaneto','4' => 'Edifícil','5' => 'Sitío','6' => 'Chácara','7' => 'Fazenda');
        $tipo = '';
        foreach($array_imovels as $key => $item){
            if($receipt->imovel->type_imovel == $key){
                $tipo .= $item;
            }
        }
    @endphp
    <h4>Imóvel a ser pesquisado </h4>
    <p>
        Um(a) {{ $tipo }} localizado(a) no(a) {{ $receipt->imovel->address }}, 
        nº {{ $receipt->imovel->number }}, 
        bairro {{ $receipt->imovel->district }}, cidade 
        {{ $receipt->imovel->city }}/
        {{ $receipt->imovel->state }}

        @if(!empty($receipt->imovel->registry))
            sob a matrícula nº {{ $receipt->imovel->registry }}
        @endif
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
        <small>
            @if(!empty($receipt->client->company))
                {{ $receipt->client->company }}<br>CNPJ {{ $receipt->client->cnpj }}
            @else
                {{ $receipt->client->name }}<br>CPF {{ $receipt->client->cpf }}
            @endif
        <small>
    </div>
    <div class='signature'>
        <small>Regulariza Imóveis Ltda Me<br>
        CGC 10.347.372/0001-42<br>
        Av. Juca sampaio, Travessa Juca Sampaio, nº 202 -
        Barro Duro - Maceió/AL<br>
        E-mail.regularizaimoveis@live.com<br>
        Tel: 3027-7333</small>
    </div>

</body>
</html>