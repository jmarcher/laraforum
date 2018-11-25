@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">
                            {{ $thread->creator->name }}
                        </a> {{ __('posted:') }}
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.partials.reply')
                @endforeach
            </div>
        </div>
        @auth
            <div class="row justify-content-center">
                <div class="col-md-8">
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
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in the forum.</p>
        @endauth
    </div>
@endsection
