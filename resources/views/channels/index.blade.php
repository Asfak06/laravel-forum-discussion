@extends('layouts.app')

@section('content')

            <div class="card card-default">
                <div class="card-header">
                 <strong>Channels :</strong>
                 <a href="{{ route('channels.create') }}" class="btn btn-success btn-sm float-right">Add new</a>
                </div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                              <th>
                                    Name
                              </th>  
                              <th>
                                    Edit
                              </th>

                              <th>
                                    Delete
                              </th>
                        </thead>

                        <tbody>
                              @foreach($channels as $channel)
                                    <tr>
                                          <td>{{ $channel->title }}</td>
                                          <td>
                                                <a href="{{ route('channels.edit', ['channel' => $channel->id ]) }}" class="btn btn-sm btn-info">Edit</a>
                                          </td>
                                          <td>
                                                <form action="{{ route('channels.destroy', ['channel' => $channel->id ]) }}" method="post">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="btn btn-sm btn-danger" type="submit">Destroy</button>
                                                </form>
                                                
                                          </td>
                                    </tr>
                              @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection
