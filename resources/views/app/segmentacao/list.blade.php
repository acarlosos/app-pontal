@extends('layouts.app') 
@section('content')
<div class="container container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">LISTAGEM DE SEGMENTAÇÕES <a class="btn btn-success float-right btn-sm text-white" href="{{route('home')}}"><i class="fa fa-undo"></i> VOLTAR</a></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    @includeIf('app.segmentacao.table')
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</div>
@endsection