@extends('layouts.main',['activePage' => 'aviso','titlePage' => 'Nuevo Aviso'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('aviso.store')}}" method="post" class="form-horizontal">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Aviso</h4>
                            </div>
                            <div class="card-body">
                                @if (session('message'))
                                <div class="alert alert-success" role="message">
                                    {{ session('message') }}
                                </div>
                                @endif
                                {{--@if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif--}}
                                <div class="row">
                                    <label for="titulo" class="col-sm-2 col-form-label">Titulo</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="titulo" placeholder="Ingrese el titulo" autofocus>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="descripcion" class="col-sm-2 col-form-label">Descripcion</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="descripcion" placeholder="Ingrese la descripcion">
                                    </div>
                                </div>
                            </div>
                            <!--Footer-->
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                            <!--End Footer-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection