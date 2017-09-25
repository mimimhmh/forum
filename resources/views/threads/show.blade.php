@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ route('profiles', $thread->creator) }}">
                                        {{ $thread->creator->name }}
                                    </a>
                                    Posted:
                                    <strong>{{ $thread->title }}</strong>
                                </span>

                                @can('update', $thread)
                                    <form action="{{ $thread->path() }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>


                    {{--{{ $replies->links() }}--}}

                    @if(auth()->check())
                        <form method="post" action="{{ $thread->path() . '/replies' }}">
                            {{ csrf_field() }}
                            <textarea name="body"
                                      id="body"
                                      class="form-control"
                                      rows="5"
                                      placeholder="Have something to say?">
                    </textarea>
                            <br/>
                            <button type="submit" class="btn btn-default">Post</button>
                        </form>
                    @else
                        <p class="text-center">
                            Please
                            <a href="{{ route('login') }}">Sign In</a>
                            to make a reply.
                        </p>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }}<br/>
                                by
                                <a href="#">{{ $thread->creator->name }}</a>, and currently has
                                <span v-text="repliesCount"></span>
                                {{ str_plural('comment', $thread->replies_count) }}.
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </thread-view>
@endsection
