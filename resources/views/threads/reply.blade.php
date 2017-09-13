<div class="panel panel-default">

    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="#">
                    {{ $reply->owner->name }}
                </a> said
                    {{ $reply->created_at->diffForHumans() }}
            </h5>
            &nbsp;
            <div>
                <form method="post" action="/replies/{{ $reply->id }}/favorites">
                    {{ csrf_field() }}
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
</div>