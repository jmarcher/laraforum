@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }}
        {{ __('favorited a reply in') }} <a
            href="{{ $activity->subject->favorited->path() }}">{{ $activity->subject->favorited->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
