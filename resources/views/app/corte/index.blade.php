<div class="modal modal-warning fade" id="modal-corte" style="display: none;">
    <div class="modal-dialog">
        <form action="{{route('corte.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Corte no arquivo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="arquivo_csv">Arquivo CSV</label>
                        <input type="file" id="arquivo_csv" name="arquivo_csv" id="arquivo_csv">
                        <p class="help-block">Arquivo de no maximo 50mb.</p>
                    </div>
                    <div class="form-group">
                        <label for="arquivo_xls">Arquivo Excel</label>
                        <input type="file" id="arquivo_xls" name="arquivo_xls" id="arquivo_xls">
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