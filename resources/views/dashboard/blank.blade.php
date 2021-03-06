@extends('layouts.skeleton')

@section('content')

  <div class="mw6 center mt5 mt6-ns mb4 ph3 ph0-ns">
    <div class="tc mb5">
      <img src="img/dashboard/blank.svg">
    </div>
    <h2 class="f2 mb4 normal tc lh-title">{{ trans('dashboard.dashboard_blank_title') }}</h2>
    <p class="tc f4 mb4">{{ trans('dashboard.dashboard_blank_description') }}</p>
  </div>

@endsection
