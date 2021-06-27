<table class="table table-condensed">
    <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>Arquivo TXT</th>
            <th>Data Solicitada</th>
            <th>Progresso</th>
            <th style="width: 40px"><i class="fa fa-download"></i></th>
        </tr>
        @foreach($segmentacoes as $segmentacao)
            <tr>
                <td>{!! $segmentacao->id !!}.</td>
                <td>{!! $segmentacao->arquivo_txt !!}</td>
                <td>{!! isset($segmentacao->data) ? $segmentacao->data->format('d-m-Y') : 'NULL' !!}</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar {!! $segmentacao->getCor()!!} " style="width: {!! is_numeric($segmentacao->getPorcentagem()) ? $segmentacao->getPorcentagem() : '100' !!}%"><span class="">{!! is_numeric($segmentacao->getPorcentagem())? $segmentacao->getPorcentagem() .'%':$segmentacao->getPorcentagem() !!}</span></div>
                    </div>
                </td>
                <td> <a href="{{route('segmentacao.download' , ['id'=> $segmentacao->id])}}"><i class="fa fa-file-o"></i></a> </td>
            </tr>
        @endforeach
    </tbody>
</table>
