@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h1>{{ $profileUser->name }}</h1>
                    <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                </div>
                <div class="card-body">
                    @foreach($groupedActivities as $date => $activities)
                        <h3 class="pb-2 mt-4 mb-2 border-bottom">{{ $date }}</h3>
                        @foreach($activities as $activity)
                            @if(view()->exists("profiles.activities.{$activity->type}"))
                                @include("profiles.activities.{$activity->type}")
                            @endif
                        @endforeach
                    @endforeach
                    {{--{{ $threads->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
