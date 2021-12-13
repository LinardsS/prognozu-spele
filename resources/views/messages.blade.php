@extends('layouts.app')

@section('content')
  <h1>Messages</h1>
  @if(count($messages) > 0)
    <table class="table" style="table-layout: fixed; width: 100%">
    <thead class="thead-light">
      <tr>
        <th scope="col">Vārds</th>
        <th scope="col">E-pasts</th>
        <th scope="col">Ziņa</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($messages as $message)
      <tr>
        <td>{{$message->name}}</td>
        <td>{{$message->email}}</td>
        <td style="word-wrap: break-word">{{$message->message}}</td>
        <td>
          @if($message->read == 0)
          <form class="" action="{{ route('messages.read', $message)}}" method="post">
            @csrf
            <button type="submit" class="btn btn-danger" style="align: right;">
               Atzīmēt kā lasītu
            </button>
         </form>
          @else
          <form class="" action="{{ route('messages.unread', $message)}}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary" style="align: right;">
               Atiestatīt kā nelasītu
            </button>
          </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @endif
@endsection

@section('sidebar')
  @parent
@endsection
