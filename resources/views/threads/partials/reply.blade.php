<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile.get', $reply->owner) }}">{{ $reply->owner->name }}</a> {{ __('said') }} {{ $reply->created_at->diffForHumans() }}
                </h5>
                <favorite :reply="{{ $reply }}"></favorite>
                {{--<form method="POST" action="/replies/{{ $reply->id }}/favorites">--}}
                    {{--@csrf--}}
                    {{--<button--}}
                        {{--class="btn btn-default" {{ $reply->isFavorited(auth()->id()) ? 'disabled' : '' }}>{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}</button>--}}
                {{--</form>--}}
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="body" id="" cols="30" rows="10" class="form-control" v-model="body"></textarea>
                </div>

                <div class="btn btn-sm btn-primary" @click="update">{{ __('Update') }}</div>
                <div class="btn btn-sm btn-link" @click="editing = false">{{ __('Cancel') }}</div>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('update', $reply)
            <div class="card-footer">
                <div class="level">
                    <div class="btn btn-sm btn-secondary" @click="editing = true">{{ __('Edit') }}</div>
                    <button type="submit" class="btn btn-danger btn-sm ml-1" @click="destroy">{{ __('Delete') }}</button>
                </div>
            </div>
        @endcan
    </div>
</reply>
