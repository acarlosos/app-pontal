<table class="table table-condensed">
    <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>Arquivo CSV</th>
            <th>Arquivo XLS</th>
            <th>Progresso</th>
            <th style="width: 40px"><i class="fa fa-download"></i></th>
        </tr>
        @foreach($cortes as $corte)
            <tr>
                <td>{!! $corte->id !!}.</td>
                <td>{!! $corte->arquivo_csv !!}</td>
                <td>{!! $corte->arquivo_xls !!}</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar {!! $corte->getCor()!!} " style="width: {!! is_numeric($corte->getPorcentagem()) ? $corte->getPorcentagem() : '100' !!}%"><span class="">{!! is_numeric($corte->getPorcentagem())? $corte->getPorcentagem() .'%':$corte->getPorcentagem() !!}</span></div>
                    </div>
                </td>
                <td> <a href="{{route('corte.download' , ['id'=> $corte->id])}}"><i class="fa fa-file-o"></i></a> </td>
            </tr>
        @endforeach
    </tbody>
</table>