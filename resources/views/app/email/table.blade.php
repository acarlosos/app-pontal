<table class="table table-condensed">
    <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>CSV Mala</th>
            <th>CSV Complementar</th>
            <th>Progresso</th>
            <th style="width: 40px"><i class="fa fa-download"></i></th>
        </tr>
        @foreach($emails as $email)
            <tr>
                <td>{!! $email->id !!}.</td>
                <td>{!! $email->csv_mala !!}</td>
                <td>{!! $email->arquivo_complementar !!}</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="progress-bar {!! $email->getCor()!!} " style="width: {!! is_numeric($email->getPorcentagem()) ? $email->getPorcentagem() : '100' !!}%"><span class="">{!! is_numeric($email->getPorcentagem())? $email->getPorcentagem() .'%':$email->getPorcentagem() !!}</span></div>
                    </div>
                </td>
                <td> <a href="{{route('email.download' , ['id'=> $email->id])}}"><i class="fa fa-file-o"></i></a> </td>
            </tr>
        @endforeach
    </tbody>
</table>