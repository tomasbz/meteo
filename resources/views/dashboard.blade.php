@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row mt-5 mb-5">
            {{--weather metrics--}}
            <div class="col-md-6">
                <h2 class="pb-3">Weather metrics</h2>
                @if(count($weatherMetrics) > 0)
                    <ul class="list-group pr-5 mb-5">
                        @foreach($weatherMetrics as $key => $metric)
                            <li class="list-group-item d-flex justify-content-between align-items-center mb-1">
                                {{$metric['title']}}
                                <span class="badge badge-primary badge-pill">{!!$metric['value']!!}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mb-5">No data</p>
                @endif
            </div>
            {{--subscription form--}}
            <div class="col-md-6">
                <h2 class="pb-3">Subscription</h2>
                {!! Form::open(['action' => 'SubscriberController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', '', ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('email', 'Email')}}
                        {{Form::email('email', '', ['class' => 'form-control'])}}
                    </div>
                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection