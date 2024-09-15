@extends('frontend.layouts.master')

@section('content')
    <section class="fp__breadcrumb" style="background: url(images/counter_bg.jpg);">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>User Notifications</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#">Notifications</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="fp__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (!empty($notifications) && count($notifications) > 0)
                        @foreach ($notifications as $notification)
                            <div
                                style="border-left: 5px solid orange; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-bottom: 20px; padding: 15px;">
                                <h5 style="margin: 0;">{{ $notification['type'] }}</h5>
                                <p style="margin-top: 10px;">{{ $notification['message'] }}</p>
                            </div>
                        @endforeach
                    @else
                        <p>No notifications found.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
