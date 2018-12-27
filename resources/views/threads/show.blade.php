@extends('layouts.app')

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <h5 class="flex">
                                    <a href="{{ route('profile.get', $thread->creator) }}">
                                        {{ $thread->creator->name }}
                                    </a> {{ __('posted:') }}
                                    {{ $thread->title }}
                                </h5>
                                @can('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @added="repliesCount++"
                             @removed="repliesCount--"></replies>


                    {{--{{ $replies->links() }}--}}
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>{{ __('This thread was published') }} {{ $thread->created_at->diffForHumans() }} {{ __('by') }}
                                <a
                                    href="#">{{ $thread->creator->name }}</a>, and currently
                                has <span
                                    v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                            </p>
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->is_subscribed_to) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
