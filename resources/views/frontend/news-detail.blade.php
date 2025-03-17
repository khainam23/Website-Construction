@extends('frontend.layouts.master')
@section('title', 'Tin tức')

@section('style')
<link rel="stylesheet" href="{{ asset('frontend/css/news.css') }}" />

@endsection

@section('content')
 
<div class="container">
    <div class="news-title">
        <div>
            <h1 style="color:#B4B4B4">{{ __('NEWS_EVENTS') }}</h1>
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
        <div class="col-md-8 news-detail-title">
            <h1>{{$news->postTranslations->first()->title ??''}}</h1>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 news-detail-left">
            <img class="news-detail-left-img" src="{{asset($news->image)}}" alt="">
            <div class="news-detail-content">{!!$news->postTranslations->first()->detail ?? '' !!}</div>
        </div>
        <div class="col-md-4">
            <div class="news-detail-card-title">
                <div class="number"><p>{{ __('Related_news') }}</p></div>
            </div>
            <div class="news-detail">

                @foreach($newsList as $newsDetail)
                <a href="{{ route('web.newsDetail', ['slug' => $newsDetail->slug])}}">
                    <div class=" news-detail-card">
                        <img src="{{asset($newsDetail->image)}}" alt="">
                        <p>{{$newsDetail->postTranslations->first()->title ?? ''}}</p>
                        <div>
                            <i class="fa-solid fa-circle-chevron-right"></i>
                            <p>{{ __('See_more') }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection