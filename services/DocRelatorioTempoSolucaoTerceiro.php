<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Como tudo funciona.</h3>
    </div>
    <div class="panel-body">

<ul>
    <li>1 - Número: Traz o código do chamado.
    </li>
    <li>2 - Data Inicio: Traz a data de criação do chamado, data de cadastro.
    </li>
    <li>3 - Data Fim: Traz a data de encerramento do chamado, em caso onde o chamado esteja em
                  atendimento, é usado a data atual da geração do relatório.
    </li>
    <li>4 - Tempo: Traz o tempo total em horas entre a Data Inicio e Data Fim.
    </li>
    <li>5 - Problema Técnico: Informa o problema selecionado pelo técnico no momento do assentamento,
        o que pode ser o mesmo informado pelo usuário ou alterado enquanto o chamado estiver em atendimento.
    </li>
    <li>6 - SLA Técnico: Traz o horário cadastrado no problema técnico.
    </li>
    <li>7 - Status: Informa o status atual do chamado.
    </li>
    <li>8 - Prioridade: Informa a prioridade do problema técnico.
    </li>
    <li>9 - SLA Atend.: SLA de Atendimento baseado no problema informado pelo Solicitante.
    </li>
    <li>10 - Atendende: O usuário que está como atendente do chamado.
    </li>
    <li>11 - DIFF Técnico: Total de tempo calculado entre (Tempo - DIFF Técnico).
    </li>
    <li>12 - Tempo Útil: Total de tempo calculo levando em consideração o tempo útil. O tempo útil é feito da seguinte forma:
        <ol>
            <li>Necessário informar: Horario de entrada, horario de almoço, horário de saida e sábado.
            </li>
            <li>Esse tempo são cadastrado por departamento e são carregados automaticamente neste relátório de existir
                , porém podem ser alterados neste relatório no momento da geração.
            </li>
            <li>
                É calculado a diferença entre a Data Inicio e Data Fim em horas úteis, ou seja é descontado o final de semana e noite.
            </li>
        </ol>
    </li>
    <li>
        13 - Tempo Terceiro: Mostra o total de tempo útil que o chamado ficou em poder de terceiros,
        o que também leva em consideração a configuração do departamento em relação aos Horaŕios cadastrados.
    </li>
    <li>
        14 - Útil Real: É um cálculo entre o tempo útil reduzindo do tempo terceiro.
    </li>
    <li>
        15 - % SLA: Mostra qual a porcentagem que o tempo está para a data de ultrapassar o SLA técnico.
    </li>

    <li style="color: #000000 ">
        <div class="jumbotron">
            *Importante: O sistema não consegue trazer o tempo útil do chamado enviado para terceiro, se estiver com pendência
            de remoção, ou seja, é importante em alguns casos remover de terceiro para ter o real valor útil do tempo em terceiro.
        </div>
    </li>
</ul>

    </div>
</div>