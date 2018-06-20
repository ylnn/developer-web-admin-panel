@extends('layouts.front')

@section('content')

    @isset($articles)
        @foreach ($articles as $article)
            <div class="article">
                <div class="title">{{$article->title}}</div>
                @if($article->status == "draft")
                    <div class="badge badge-warning">DRAFT</div>
                @endif
                <div class="date">{{$article->created_at->format('l, d F Y')}}</div>
                <div class="summary">{{$article->summary}}</div>
                <div class="read-more">
                    <a href="{{ route('article.detail', [$article->id, $article->url]) }}" class="btn btn-dark">Read more...</a>
                </div>
            </div>
        @endforeach
    @endif
@endsection