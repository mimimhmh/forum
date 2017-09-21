<div class="panel panel-default">

    <div id="reply-{{ $reply->id }}" class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profiles', $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said
                    {{ $reply->created_at->diffForHumans() }}
            </h5>
            &nbsp;
            <div>
                <form method="post" action="/replies/{{ $reply->id }}/favorites">
                    {{ csrf_field() }}
                    @if($reply->isFavorited())
                        <input type="hidden" name="_method" value="DELETE">
                    @endif
                    <button type="submit" class="btn {{ $reply->isFavorited() ? 'btn-primary': 'btn-default'}}" >
                        {{ $reply->favorites_count }} &nbsp;
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>

    @can('update')
        <div class="panel-footer">
            <form method="post" action="/replies/{{ $reply->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    @endcan
</div>