@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Generate new Matrix Cube</div>
            </div>
            <form action="{{ route('cube.store') }}" method="POST">
                {{ csrf_field() }}
                @if (count($errors))
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="form-group">
                    <label for="n" class="col-sm-2 control-label">Cube dimention: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="n" name="n" placeholder="N Dimention for the cube">
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-default">Post it!</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h1>Commands</h1></div>
            </div>
            <div class="panel panel-body">
                <command></command>
            </div>
        </div>
    </div>
</div>
@endsection