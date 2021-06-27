<div class="modal modal-success fade" id="modal-email" style="display: none;">
    <div class="modal-dialog">
        <form action="{{route('email.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">E-mail complementar</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="csv_mala">CSV Mala</label>
                        <input type="file" id="csv_mala" name="csv_mala" id="csv_mala">
                        <p class="help-block">Arquivo de no maximo 50mb.</p>
                    </div>
                    <div class="form-group">
                        <label for="arquivo_complementar">CSV Complementar</label>
                        <input type="file" id="arquivo_complementar" name="arquivo_complementar" id="arquivo_complementar">
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