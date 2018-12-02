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
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea type="text" name="body" id="body" class="form-control"
                                          aria-describedby="helpId"></textarea>
                            </div>
                            <button class="btn btn-primary"
                                    type="submit">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
