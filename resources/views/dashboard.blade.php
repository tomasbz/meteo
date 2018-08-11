@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row mt-5 mb-5">
            {{--weather metrics--}}
            <div class="col-md-6">
                <h2 class="pb-3">Weather metrics</h2>
                @if(count($weatherMetrics) > 0)
                    <ul class="list-group pr-5 mb-5">
                        <li class="list-group-item d-flex justify-content-between align-items-center mb-1">
                            Title
                            <span class="badge badge-primary badge-pill">val</span>
                        </li>
                    </ul>
                @else
                    <p class="mb-5">No data</p>
                @endif
            </div>
            {{--subscription form--}}
            <div class="col-md-6">
                <h2 class="pb-3">Subscription</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection