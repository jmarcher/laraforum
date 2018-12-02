@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>

                    <div class="card-body">
                        <form action="/threads" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Channel</label>
                                <select class="custom-select" name="channel_id" id="channel_id" required>
                                    <option selected>Select one</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}"
                                            {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       aria-describedby="helpId" value="{{ old('title') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea type="text" name="body" id="body" class="form-control"
                                          aria-describedby="helpId" required>{{ old('body') }}</textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary"
                                        type="submit">Publish
                                </button>
                            </div>
                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
