@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">
                            {{ $thread->creator->name }}
                        </a>
                            Posted:
                        <strong>{{ $thread->title }}</strong>
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form method="post" action="{{ $thread->path() . '/replies' }}">
                    {{ csrf_field() }}
                    <textarea name="body"
                              id="body"
                              class="form-control"
                              rows="5"
                    placeholder="Have something to say?">
                    </textarea>
                    <br />
                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            </div>
        </div>
        @else
            <p class="text-center">
                Please
                <a href="{{ route('login') }}">Sign In</a>
                to make a reply.
            </p>
        @endif
    </div>
@endsection
