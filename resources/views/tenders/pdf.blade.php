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

        .text-right{
            text-align: right;
        }

        .data {
            text-align: center;
            margin: 50px 0;
        }

        body table {
            width: 100%;
        }

        body table tr td {
            padding: 3px;
            border: #000000 1px solid;
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

        if(!empty($tender->imovel_id)){
            $array_imovels = array('1' => 'Casa','2' => 'Terreno','3' => 'Lotemaneto','4' => 'Edifícil','5' => 'Sitío','6' => 'Chácara','7' => 'Fazenda');
            $tipo = '';
            foreach($array_imovels as $key => $item){
                if($tender->imovel->type_imovel == $key){
                    $tipo .= $item;
                }
            }
        }
    @endphp

    <h3>PROPOSTA DE SERVIÇO</h3>

    <p><strong>CONTRATADA:</strong>
        REGULARIZA IMÓVEIS LTDA, com sede nesta capital, na Tv. Juca Sampaio, nº 202,
        Barro Duro, inscrita no CNPJ sob o nº 10.347.372/0001-42, aqui representada por seu sócio, administrador,
        SEVERINO SILVIO DOS SANTOS LUZ, brasileiro, divorciado, empresário, portador da carteira da cédula de
        identidade nº 98001041976/SSP-Al, inscrito no CPF sob nº 923.835.134-15, residente e domiciliado nesta
        capital. As partes acima, nomeadas e qualificadas, por seus representantes legais abaixo assinados, têm
        entre si, justo e acertado, o presente Contrato de Prestação de Serviços que se regerá pelas cláusulas e
        condições a seguir expostas:
    </p>

    <p><strong>CONTRATANTE:</strong>
        @if(!empty($tender->client->company))
            {{ $tender->client->company }}, CNPJ {{ $tender->client->cnpj }}, 
        @else
            {{ $tender->client->name }}, {{ $tender->client->profession }}, 
            portador da carteira da cédula de identidade de nº 
            {{ $tender->client->rg }} {{ $tender->client->ssp }},
            inscrito no CPF sob nº {{ $tender->client->cpf }},
        @endif
        
        residente no(a) {{ $tender->client->address }}, 
        nº {{ $tender->client->number }}, 
        {{ $tender->client->district }}, 
        {{ $tender->client->city }}/{{ $tender->client->state }}.
    </p>

    @if(!empty($tender->imovel_id))
        <p><strong>DO IMÓVEL:</strong>: 
            O objeto do presente instrumento particular é a prestação dos serviços de
            assessoria objetivando a regularização do imóvel <strong>{{ $tipo }}</strong> de propriedade da CONTRATANTE situado nesta 
            capital, localizado no endereço {{ $tender->imovel->address }}, 
            nº {{ $tender->imovel->number }}, {{ $tender->imovel->district }}, 
            {{ $tender->imovel->city }}/{{ $tender->imovel->state }}, 
            requerendo a CONTRATADA perante a municipalidade, em especial junto a SMCCU Secretaria Municipal
            de Controle e Convívio Urbano, protocolando e acompanhando o processo até o seu final, com a
            consequente expedição do alvará de construção/reforma do imóvel acima mencionado.
        </p>
    @endif



    <h3>RELATÓRIO DE CONSULTA</h3>

    <table>
        <thead>
            <tr>
                <th scope="col">Descrição da documentação</th>
                <th scope="col" class="text-center">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Valor venal do imóvel</td>
                <td class="text-right">{{ number_format($tender->venal_value, 2,',','.') }}</td>
            </tr>
            @if(!empty($tender->iptu))
                <tr>
                    <td>Débito IPTU</td>
                    <td class="text-right">{{ number_format($tender->iptu, 2,',','.') }}</td>
                </tr>
            @endif
            @if(!empty($tender->condominium))
                <tr>
                    <td>Débito condomínio</td>
                    <td class="text-right">{{ number_format($tender->condominium, 2,',','.') }}</td>
                </tr>
            @endif
            <tr>
                <td>Escritura do Imóvel</td>
                <td class="text-right">{{ number_format($tender->deed_fee, 2,',','.') }}</td>
            </tr>
            <tr>
                <td>ITBI</td>
                <td class="text-right">{{ number_format($tender->itbi, 2,',','.') }}</td>
            </tr>
            <tr>
                <td>Registro do Imóvel</td>
                <td class="text-right">{{ number_format($tender->registration_fee, 2,',','.') }}</td>
            </tr>
            <tr>
                <td>Certidão de Ônus</td>
                <td class="text-right">{{ number_format($tender->certificaty, 2,',','.') }}</td>
            </tr>
            <tr>
                <td>Honorários Despachante</td>
                <td class="text-right">{{ number_format($tender->letter, 2,',','.') }}</td>
            </tr>
            @if(!empty($tender->portion))
                <tr>
                    <td>Parcelas</td>
                    <td class="text-right">{{ $tender->portion }}</td>
                </tr>
                <tr>
                    <td>
                        @php
                            // Calculo de juros compostas
                            $investiment_value = 
                                $tender->iptu 
                                + $tender->itbi 
                                + $tender->deed_fee 
                                + $tender->registration_fee 
                                + $tender->certificaty 
                                + $tender->letter 
                                + $tender->iptu 
                                + $tender->condominium;

                            $valor_inicial =  $investiment_value;
                            $meses =  $tender->portion;
                            $taxa_de_juros = 4;
                            $investimento_acumulado = $valor_inicial;
                            $juros_compostos_total = 0;
                            for ($i = 0; $i < $meses; $i++) {
                                $juros_compostos = ($investimento_acumulado * $taxa_de_juros) / 100;
                                $juros_compostos_total += $juros_compostos;
                                $investimento_acumulado += $juros_compostos;
                            }

                            $count = 1;
                            $juros_total = 0;
                            for ($i = 0; $i < $meses; $i++) {
                                $juros = ($valor_inicial * $taxa_de_juros) / 100;
                                $juros_total += $juros;
                                $valor_inicial += $juros;
                                echo $count++."º parcela R$ ".number_format($juros,2,',','.')."<br>";
                            }

                        @endphp
                    
                    </td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Juros</td>
                    <td class="text-right">{{ number_format($tender->fees, 2,',','.') }}</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total do investimento</strong></td>
                <td class="text-right"><strong>{{ number_format($tender->total_value, 2,',','.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    @php
        $dia = date("d");
        $mes = date("n");
        $ano = date("Y");
        $mesext = array(1 => "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
        $diaext = array("Sun" => "Domingo", "Mon" => "Segunda", "Tue" => "Terçaa", "Wed" => "Quarta", "Thu" => "Quinta", "Fri" => "Sexta", "Sat" => "Sábado");
        echo "<p class='data'>Maceió, $dia dias(s) do mês de $mesext[$mes] do ano de $ano</p>";
    @endphp

    <div class='signature'>
        <small>Contratate</small>
    </div>
    <div class='signature'>
        <small>Contratada</small>
    </div>

</body>
</html>