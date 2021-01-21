@extends('layouts.app')

@section('content')
      @if($discussions->count()>0)
        @foreach($discussions as $d)
            <div class="card ">
                <div class="card-header alert-secondary">
                    <img src="{{ $d->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
                    <span>{{ $d->user->name }}, <b>{{ $d->created_at->diffForHumans() }}</b></span>
                    @if($d->hasBestAnswer())
                    <span class="badge badge-dark ml-2">closed</span>
                    @else
                    <span class="badge badge-success ml-2">open</span>
                    @endif
                    <a href="{{ route('discussion', ['slug' => $d->slug ]) }}" class="btn btn-primary float-right">view</a>
                </div>

                <div class="card-body">
                    <h4 class="text-center">
                        <b>{{ $d->title }}</b>
                    </h4>
                    <p class="text-center">
                        {!! Markdown::convertToHtml(str_limit($d->content, 100)) !!}
                        
                    </p>
                </div>
                <div class="card-footer">

                        <span>
                            {{ $d->replies->count() }} Replies
                        </span>
                        <a href="{{ route('channel', ['slug' => $d->channel->slug ]) }}" class="float-right badge badge-pill badge-secondary">{{ $d->channel->title }}</a>
                    </div>

            </div>
        @endforeach
        @else
                <div class="card-body">
                    <h4 class="text-center">
                        <b>Nothing yet</b>
                    </h4>
                </div>         
        @endif
        <div class="text-center">
            {{ $discussions->links() }}
        </div>
@endsection
