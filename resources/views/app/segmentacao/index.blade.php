<div class="modal modal-danger fade" id="modal-segmentacao" style="display: none;">
    <div class="modal-dialog">
        <form action="{{route('segmentacao.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Segmentação no arquivo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="data">Data para Segmentação</label>
                        <input id="data" type="date" name="data" required>
                        <p class="help-block">Escolha a data para segmentar o arquivo.</p>
                    </div>
                    <div class="form-group">
                        <label for="arquivo_txt">Arquivo TXT</label>
                        <input type="file" id="arquivo_txt" name="arquivo_txt" id="arquivo_txt">
                        <p class="help-block">Arquivo de no maximo 50mb.</p>
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
