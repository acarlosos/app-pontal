<table class="table table-condensed">
    <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>Arquivo</th>
            <th>Progresso</th>
            <th style="width: 40px"><i class="fa fa-download"></i></th>
        </tr>
        @foreach($remessas as $remessa)
            <tr>
                <td>{!! $remessa->id !!}.</td>
                <td>{!! $remessa->arquivo_entrada !!}</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar {!! $remessa->getCor()!!} " style="width: {!! is_numeric($remessa->getPorcentagem()) ? $remessa->getPorcentagem() : '100' !!}%"><span class="">{!! is_numeric($remessa->getPorcentagem())? $remessa->getPorcentagem() .'%':$remessa->getPorcentagem() !!}</span></div>
                    </div>
                </td>
                <td> <a href="{{route('remessa.download' , ['id'=> $remessa->id])}}"><i class="fa fa-file-o"></i></a> </td>
            </tr>
        @endforeach
    </tbody>
</table>