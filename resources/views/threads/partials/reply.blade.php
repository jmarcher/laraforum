<div class="card">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                {{ $reply->owner->name }} {{ __('said') }} {{ $reply->created_at->diffForHumans() }}
            </h5> 
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                @csrf
                <button class="btn btn-default" {{ $reply->isFavorited(auth()->id()) ? 'disabled' : '' }}>{{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count()) }}</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
