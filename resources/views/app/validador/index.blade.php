@inject( 'validador' , 'App\Models\Validador')
<div class="modal modal-purple fade" id="modal-validador" style="display: none;">
    <div class="modal-dialog">
        <form action="{{route('validador.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Envio para Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="arquivo">Arquivo</label>
                        <input type="file" id="arquivo" name="arquivo" id="arquivo">
                        <p class="help-block">Arquivo de no maximo 50mb.</p>
                    </div>
                    <div class="form-group">
                        <label>Layout de entrada</label>
                        <select class="form-control" name="layout_entrada">
                            @foreach ($validador->validador() as $key => $item)
                                <option value="{{$item}}">{{$key}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-outline">Enviar</button>
                </div>
            </div>
        </form>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>