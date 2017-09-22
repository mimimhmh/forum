<reply inline-template :attributes="{{ $reply }}" v-cloak>

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
            <div v-if="editing">

                <div class="form-group">
                    <textarea class="form-control" name="body" v-model="body" required></textarea>
                </div>

                <button class="btn btn-primary btn-xs" @click="update">Update</button>
                <button class="btn btn-link btn-xs" @click="cancel">Cancel</button>
            </div>

            <div v-else v-text="body"></div>

        </div>

        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-info btn-xs mr-1"
                        @click="editing = true">
                    Edit
                </button>

                <button class="btn btn-danger btn-xs"
                        @click="destroy">
                    Delete
                </button>

            </div>
        @endcan
    </div>

</reply>
