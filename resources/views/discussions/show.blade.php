
@extends('layouts.app')

@section('content')

        <div class="card alert-secondary">
            <div class="card-header">
                <img src="{{ $d->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
                <span>{{ $d->user->name }}, <b>( {{ $d->user->points }} )</b></span>
                    @if($d->hasBestAnswer())
                    <span class="badge badge-dark ml-2">closed</span>
                    @else
                    <span class="badge badge-success ml-2">open</span>
                    @endif
@if(Auth::id()==$d->user->id)
@if(!$d->hasBestAnswer())
<a href="{{ route('discussions.edit', ['slug' => $d->slug ]) }}" class="btn btn-info btn-sm float-right mt-1">Edit</a>
@endif
@endif
                @if($d->is_being_watched_by_auth_user())
                    <a href="{{ route('discussion.unwatch', ['id' => $d->id ]) }}" class="btn btn-secondary btn-sm float-right mt-1 mr-2">unwatch</a>
                @else
                    <a href="{{ route('discussion.watch', ['id' => $d->id ]) }}" class="btn btn-secondary btn-sm float-right mt-1 mr-1">watch and get notified</a>
                @endif
            </div>

            <div class="card-body">
                <h4 class="text-center">
                    <b>{{ $d->title }}</b>
                </h4>
                <hr>
                <p class="text-center">
                    {!! Markdown::convertToHtml($d->content) !!}
                </p> 

                <hr>  

                @if($best_answer)
                    <div class="text-center" style="padding: 40px;">
                        <h3 class="text-center">BEST REPLY</h3>
                        <div class="card ">
                            <div class="card-header bg-success">
                                <img src="{{ $best_answer->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
                                <span>{{ $best_answer->user->name }} <b>( {{ $best_answer->user->points }} )</b></span>
                            </div>

                            <div class="card-body">
                                {!! Markdown::convertToHtml($best_answer->content) !!}
                               
                            </div>
                            @if(Auth::id()==$d->user->id)
                            <div class="card-footer">
                                <a href="{{ route('discussion.not.best', ['id' => $best_answer->id ]) }}" class="btn btn-sm btn-primary float-right">remove as best</a>
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                    <span>
                        {{ $d->replies->count() }} Replies
                    </span>
                    <a href="{{ route('channel', ['slug' => $d->channel->slug ]) }}" class="float-right badge badge-pill badge-secondary mt-1">{{ $d->channel->title }}</a>
            </div>
        </div>

        @foreach($d->replies as $r)
            <div class="card ">
                <div class="card-header ">
                    <img src="{{ $r->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
                    <span>{{ $r->user->name }} <b>( {{ $r->user->points }} )</b></span>
                    @if(!$best_answer)
                        @if(Auth::id() == $d->user->id)
                            <a href="{{ route('discussion.best.answer', ['id' => $r->id ]) }}" class="btn btn-sm btn-primary float-right mt-1">Mark as best answer</a>
                        @endif
                    @endif
                      @if(Auth::id()==$r->user->id)
                            @if(!$r->best_answer)
                            <a href="{{ route('reply.edit', ['id' => $r->id ]) }}" class="btn btn-sm btn-info float-right mx-1">edit</a>
                            @endif
                     @endif                    
                </div>

                <div class="card-body">
                    <p class="text-center">
                       {!! Markdown::convertToHtml($r->content) !!}
                    </p>
                </div>
                <div class="card-footer">
                    @if($r->is_liked_by_auth_user())
                        <a href="{{ route('reply.unlike', ['id' => $r->id ]) }}" class="btn btn-danger btn-sm">Unlike <span class="badge">->liked by{{ $r->likes->count() }}</span></a>
                    @else
                        <a href="{{ route('reply.like', ['id' => $r->id ]) }}" class="btn btn-success btn-sm">Like</a> <span class="badge">{{ $r->likes->count() }}</span>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="card card-secondary">
            <div class="card-body">
                @if(Auth::check())
                    <form action="{{ route('discussion.reply', ['id' => $d->id ]) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="reply">Leave a reply...</label>
                            <textarea name="reply" id="reply" cols="30" rows="10" class="form-control" placeholder="Markdown enabled"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success float-right">Leave a reply</button>
                        </div>
                    </form>
                @else

                    <div class="text-center">
                        <h2>Sign in to leave a reply</h2>
                    </div>
                @endif
            </div>
        </div>
@endsection
