@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Rediģēt līgu {{$league->name}}</div>
                <div class="card-body">
                  <form class="" action="{{route('leagues.update', $league)}}" method="post">

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Nosaukums</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $league->name}}" required autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-2 col-form-label text-md-right">Apraksts</label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $league->description }}"autofocus>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="private" class="col-md-2 col-form-label text-md-right">Līga privāta</label>
                        <div class="col-md-6">
                              <input id="private" type="checkbox" class="form-control" name="private" value="{{$league->private}}"
                              @if($league->private == 1) checked @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="maxPlayers" class="col-md-2 col-form-label text-md-right">Maksimālais spēletāju skaits</label>
                        <div class="col-md-6">
                            <input id="maxPlayers" type="text" class="form-control @error('maxPlayers') is-invalid @enderror" name="maxPlayers" value="{{ $league->maxPlayers }}" required autofocus>

                            @error('maxPlayers')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                      @csrf
                      {{method_field('PUT')}}
                    <button type="submit" name="button" class="btn btn-primary">
                      Update
                    </button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
