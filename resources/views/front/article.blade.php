@extends('layouts.front')

@section('content')
    <div class="article">
            <div class="title">{{$article->title}}</div>
            <div class="date">{{$article->created_at->format('l, d F Y')}}</div>
            <div class="summary">{!! $article->description !!}
            </div>
        </div>
@endsection