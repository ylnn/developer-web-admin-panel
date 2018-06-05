@extends('layouts.front')

@section('content')

    @isset($articles)
        @foreach ($articles as $article)
            <div class="article">
                <div class="title">{{$article->title}}</div>
                <div class="date">{{$article->created_at->format('l, d F Y')}}</div>
                <div class="summary">{{ str_limit(strip_tags($article->description), 100)}}
                </div>
                <div class="read-more">
                    <a href="{{ route('article.detail', [$article->id, $article->url]) }}" class="btn btn-dark">Read more...</a>
                </div>
            </div>
        @endforeach
    @endif
@endsection