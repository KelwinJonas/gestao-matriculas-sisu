<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listagem</title>
    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin-right: 50px;
            margin-left: 50px;
            margin-bottom: 80px;
            margin-top: 4.5cm;
        }

        header {
            text-align: center;
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4.5cm;
        }
        .titulo {
            position: relative;
            top: -70px;
            font-size: 12px;
            font-weight: bolder;
            color: #03284d;
        }
        .subtitulo {
            font-weight: normal;
            position: fixed;
            top: 135px;
            font-size: 12px;
            color: #03284d;
            left: 50%;
            transform: translateX(-50%);
        }
        .quebrar_pagina {
            page-break-after: always;
        }
        table{
            margin-top: 10px;
            padding-bottom: 0px;
            border-collapse: collapse;
            width: 100%;
            position: relative;
            border: solid 1px rgb(126, 126, 126);
            border-radius: 5px;
        }
        table th {
            font-weight: 100;
            font-size: 12px;
        }
        table thead {
            border-top: 1px solid rgb(126, 126, 126);
            border-bottom: 1px solid rgb(126, 126, 126);
            background-color: #021c35;
            color: white;
        }
        #footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            border-top: 1px solid gray;
        }
        #footer .page:after{
            content: counter(page);
        }
        #modalidade {
            border: solid 1px rgb(126, 126, 126);
            border-radius: 5px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-bottom: 0px;
        }
        .esquerda {
            text-align: left;
            float: left;
        }

        .back-color-1 {
            background-color: white;
        }
        .back-color-2 {
            background-color: #d1e7fd;
        }
        .acao_afirmativa {
            font-size: 12px;
            text-align: justify;
            margin: 12px;
            position: relative;
            left: 5px;
        }
    </style>

</head>
<body style="font-family: Arial, Helvetica, sans-serif;">
    <header>
        <img src="{{public_path('img/cabecalho_listagem.png')}}" width="100%" alt="">
        <span class="titulo">
            LISTA DE CONVOCADOS<br><span style="font-weight: normal; text-transform:uppercase;" >{{$chamada->nome}}</span><br>
        </span>
    </header>
    <div>
        @foreach ($collect_inscricoes as $i => $collect)
            @if ($collect->count() > 0)
                @foreach ($collect as $j => $inscricoes)
                @php
                    $inscricao = App\Models\Inscricao::find($inscricoes->first()['id']);
                @endphp
                    <div class="subtitulo" style="margin-top: 12px;;border: 3px solid #ffffff;width: 60%;height: 10px;background-color:#ffffff;">
                    </div>
                    <h3 class="subtitulo">Curso: {{$inscricao->curso->nome}} - @switch($inscricao->curso->turno)
                        @case(App\Models\Curso::TURNO_ENUM['matutino'])
                            Matutino
                            @break
                        @case(App\Models\Curso::TURNO_ENUM['vespertino'])
                            Vespertino
                            @break
                        @case(App\Models\Curso::TURNO_ENUM['noturno'])
                            Noturno
                            @break
                        @case(App\Models\Curso::TURNO_ENUM['integral'])
                            Integral
                            @break
                        @endswitch
                    </h3>
                    <div class="body">
                        <div id="modalidade" @if($inscricoes->count() <= 40) style="page-break-inside: avoid;" @endif>
                            <h4 class="acao_afirmativa">@if($inscricao->no_modalidade_concorrencia == 'que tenham cursado integralmente o ensino médio em qualquer uma das escolas situadas nas microrregiões do Agreste ou do Sertão de Pernambuco.' ||
                            $inscricao->no_modalidade_concorrencia == 'AMPLA CONCORRÊNCIA' || $inscricao->no_modalidade_concorrencia == 'Ampla concorrência') Ampla concorrência / Ação afirmativa @else Ação afirmativa: {{$inscricao->cota->cod_cota}} - {{$inscricao->no_modalidade_concorrencia}} @endif</h4>
                            <table>
                                <thead>
                                    <tr class="esquerda">
                                        <th>Seq.</th>
                                        <th>CPF</th>
                                        <th>Cota de classificação</th>
                                        <th>Nome do candidato</th>
                                        <th>Nota</th>
                                        <th>AF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inscricoes as $k =>  $inscricao)
                                        @php
                                            $inscricao = App\Models\Inscricao::find($inscricao['id']);
                                        @endphp
                                        <tr class="@if($k % 2 == 0)back-color-1 @else back-color-2 @endif">
                                            <th>{{$k+1}}</th>
                                            <th>{{$inscricao->candidato->getCpfPDF()}}</th>
                                            <th>{{$inscricao->cotaRemanejada->cod_cota}}</th>
                                            <th class="esquerda">{{$inscricao->candidato->no_inscrito}}</th>
                                            <th>{{$inscricao->nu_nota_candidato}}</th>
                                            @if($inscricao->no_modalidade_concorrencia == 'que tenham cursado integralmente o ensino médio em qualquer uma das escolas situadas nas microrregiões do Agreste ou do Sertão de Pernambuco.')
                                                <th>SIM</th>
                                            @else
                                                @if($inscricao->st_bonus_perc == 'SIM')
                                                    <th>SIM</th>
                                                @else
                                                    <th></th>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
                <br/><div class="quebrar_pagina"></div>
            @endif
        @endforeach
    </div>
</body>
</html>
