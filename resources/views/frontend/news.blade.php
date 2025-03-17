@extends('frontend.layouts.master')
@section('title', 'Tin tức')

@section('style')
<link rel="stylesheet" href="{{ asset('frontend/css/news.css') }}" />

@endsection

@section('content')

<div class="container">
    <div class="news-title">
        <div>
            <h1 >{{ __('NEWS_EVENTS') }}</h1>
        </div>
        <div class="news-title-right">
            <a href=""><h2>{{ __('Home') }}</h2></a>
            <p>></p>
            <p>{{ __('News_events') }}</p>
        </div>
    </div>
   
</div>
<div class="container">
    <div class="row">
        @foreach($news as $new)
        <div class="col-md-6 news-card">
            <a href="{{ route('web.newsDetail', ['slug' => $new->slug])}}">
                <img src="{{asset($new->image)}}" alt="">
                <h1>{{optional($new->postTranslations)->first()->title ?? ''}}</h1>
                <p>{{optional($new->postTranslations)->first()->description ?? ''}}</p>
                <div>
                    <i class="fa-solid fa-circle-chevron-right"></i>
                    <p>{{ __('See_more') }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="news-pagination">
        {{ $news->links() }}
    </div>
</div>
@endsection