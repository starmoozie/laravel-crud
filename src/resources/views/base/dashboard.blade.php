@extends(starmoozie_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('starmoozie::base.welcome'),
        'content'     => trans('starmoozie::base.use_sidebar'),
        'button_link' => starmoozie_url('logout'),
        'button_text' => trans('starmoozie::base.logout'),
    ];
@endphp

@section('content')
@endsection