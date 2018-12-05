<div class="card">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile.get', $reply->owner) }}">{{ $reply->owner->name }}</a> {{ __('said') }} {{ $reply->created_at->diffForHumans() }}
            </h5> 
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                @csrf
                <button class="btn btn-default" {{ $reply->isFavorited(auth()->id()) ? 'disabled' : '' }}>{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
