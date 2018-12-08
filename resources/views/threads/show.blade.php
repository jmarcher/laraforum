@extends('layouts.app')

@section('content')
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
                @foreach($replies as $reply)
                    @include('threads.partials.reply')
                @endforeach

                {{ $replies->links() }}

                @auth
                    <form action="{{ $thread->path(). '/replies' }}" method="POST">
                        @csrf
                        <div class="form-group">
                    <textarea
                        name="body" id="body"
                        class="form-control" placeholder="{{ __('Have something to say?') }}"
                        aria-describedby="helpId"></textarea>
                            <small id="helpId" class="text-muted">Help text</small>
                        </div>
                        <button type="submit" class="btn btn-default">{{ __('Submit') }}</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in the
                        forum.</p>
                @endauth
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>{{ __('This thread was published') }} {{ $thread->created_at->diffForHumans() }} {{ __('by') }}
                            <a
                                href="#">{{ $thread->creator->name }}</a>, and currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
