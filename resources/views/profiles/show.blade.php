@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h1>{{ $profileUser->name }}</h1>
                    <small>{{ $profileUser->created_at->diffForHumans() }}</small>
                </div>

                <div class="card-body">
                    @foreach($threads as $thread)
                        <div class="card">
                            <div class="card-header">
                                <div class="level">
                                    <h5 class="flex">
                                        {{ $thread->creator->name }}
                                        {{ __('posted:') }}
                                        {{ $thread->title }}
                                    </h5>
                                    <span>
                                        {{ $thread->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    @endforeach

                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
