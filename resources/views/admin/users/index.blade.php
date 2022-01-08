@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lietotāji</div>

                <div class="card-body">

                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Vārds</th>
                          <th scope="col">E-pasts</th>
                          <th scope="col">Lomas</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)
                          <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{implode(', ', $user->roles()->get()->pluck('name')->toArray())}}</td>
                            <td>
                              @can('edit-users')
                                <a href="{{route('admin.users.edit', $user->id)}}">
                                  <button type="button" class="btn btn-primary float-left">Rediģēt</button>
                                </a>
                              @endcan
                              @can('delete-users')
                              <form class="" action="{{ route('admin.users.destroy', $user) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                 <button type="submit" class="btn btn-danger" style="width:80px;">
                                   Dzēst
                                 </button>
                              </form>
                              @endcan
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('sidebar')
<a href="{{route('results.NHL')}}">
  <button type="button" class="btn btn-success float-right">Ielādēt NHL rezultātus</button>
</a>
<br><br><br>
<a href="{{route('results.NBA')}}">
  <button type="button" class="btn btn-success float-right">Ielādēt NBA rezultātus</button>
</a>
<br><br><br>
<a href="{{route('results.PL')}}">
  <button type="button" class="btn btn-success float-right">Ielādēt PL rezultātus</button>
</a>
<br><br><br>
<a href="{{route('messages')}}">
  <button type="button" class="btn btn-primary float-right">Lietotāju ziņas({{auth()->user()->getMessageCount()}})</button>
</a>
@endsection
