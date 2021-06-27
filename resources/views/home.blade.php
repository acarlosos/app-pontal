
@extends('layouts.app')

@section('content')
<div class="container container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-xs-6">
            <p class="mb-0 bg-dark text-white text-center p-1">REMESSA</p>
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{!! $remessaTotal !!}</h3>
                    <p>Total envios</p>
                </div>
                <a href="{{route('remessa.list')}}">
                    <div class="icon">
                        <i class="fa fa-barcode"></i>
                    </div>
                </a>
                <a href="" data-toggle="modal" data-target="#modal-remessa" class="small-box-footer">Novo envio <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <p class="mb-0 bg-dark text-white text-center p-1">CORTE</p>
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{!! $corteTotal !!}</h3>
                    <p>Total envios</p>
                </div>
                <a href="{{route('corte.list')}}">
                    <div class="icon">
                        <i class="fa fa-scissors"></i>
                    </div>
                </a>
                <a href="" data-toggle="modal" data-target="#modal-corte" class="small-box-footer">Novo envio <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <p class="mb-0 bg-dark text-white text-center p-1">E-MAIL</p>
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{!! $emailTotal !!}</h3>
                    <p>Total envios</p>
                </div>
                <a href="{{route('email.list')}}">
                    <div class="icon">
                        <i class="fa fa-envelope-o"></i>
                    </div>
                </a>
                <a href="" data-toggle="modal" data-target="#modal-email" class="small-box-footer">Novo envio <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <p class="mb-0 bg-dark text-white text-center p-1">SEGMENTAÇÃO</p>
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{!! $segmentacaoTotal !!}</h3>
                    <p>Total envios</p>
                </div>
                <a href="{{route('segmentacao.list')}}">
                    <div class="icon">
                        <i class="fa fa-bar-chart"></i>
                    </div>
                </a>
                <a href="" data-toggle="modal" data-target="#modal-segmentacao" class="small-box-footer">Novo envio <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <p class="mb-0 bg-dark text-white text-center p-1">VALIDADOR</p>
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{!! $validadorTotal !!}</h3>
                    <p>Total envios</p>
                </div>
                <a href="{{route('validador.list')}}">
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                </a>
                <a href="" data-toggle="modal" data-target="#modal-validador" class="small-box-footer">Novo envio <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>


@include('app.remessa.index')
@include('app.corte.index')
@include('app.email.index')
@include('app.segmentacao.index')
@include('app.validador.index')
@endsection

