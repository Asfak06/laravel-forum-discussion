@extends('layouts.app')

@section('content')
            <div class="card card-default">
                <div class="card-header text-center">Edit reply</div>

                <div class="card-body">
                    <form action="{{ route('reply.update',['id'=>$reply->id]) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                              <label for="content">Reply to this discussion</label>
                              <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $reply->content }}</textarea>
                        </div>
                        <div class="form-group">
                              <button class="btn btn-success pull-right" type="submit">update reply</button>
                        </div>
                    </form>
                </div>
            </div>

@endsection
