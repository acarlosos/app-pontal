<table class="table table-condensed">
    <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>Arquivo</th>
            <th>Progresso</th>
            <th style="width: 40px; text-align: center;" colspan="3"><i class="fa fa-download"></i></th>
        </tr>
        @foreach($validadors as $validador)
            <tr>
                <td>{!! $validador->id !!}.</td>
                <td>{!! $validador->arquivo_entrada !!}</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar {!! $validador->getCor()!!} " style="width: {!! is_numeric($validador->getPorcentagem()) ? $validador->getPorcentagem() : '100' !!}%"><span class="">{!! is_numeric($validador->getPorcentagem())? $validador->getPorcentagem() .'%':$validador->getPorcentagem() !!}</span></div>
                    </div>
                </td>
                <td style="width:10px;">
                    <a href="{{route('validador.downloadSuccess' , ['id'=> $validador->id])}}"><i class="fa fa-file-o text-success"></i></a>
                </td>
                </td>
                <td style="width:10px;">
                    <a href="{{route('validador.downloadError' , ['id'=> $validador->id])}}"><i class="fa fa-exclamation-triangle text-danger"></i></a>
                </td>
                </td>
                <td style="width:10px;">
                    <a href="{{route('validador.downloadLog' , ['id'=> $validador->id])}}"><i class="fa fa-exclamation text-primary"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
