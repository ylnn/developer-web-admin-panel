@extends('layouts.front')

@section('content')
    <div class="article">
            <div class="title">{{$article->title}}</div>
            @if($article->status == "draft")
                <div class="badge badge-warning">DRAFT</div>
            @endif
            <div class="date">{{$article->created_at->format('l, d F Y')}}</div>
            <div class="excerpt">{{ $article->excerpt }}</div>
            <div class="summary">{!! $replaced !!}</div>
        </div>
@endsection