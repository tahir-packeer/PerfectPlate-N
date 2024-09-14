@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Admin Notifications</h1>
        </div>

        <div class="section-body">
            @if (!empty($notifications) && count($notifications) > 0)
                @foreach ($notifications as $notification)
                    <div class="card mb-4 shadow-sm" style="border-left: 5px solid orange; border-radius: 8px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="notification-content">
                                    <h5 class="card-title font-weight-bold">{{ $notification['type'] ?? 'Notification' }}
                                    </h5>
                                    <p class="card-text">{{ $notification['message'] ?? 'No message available.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No notifications available.</p>
            @endif
        </div>
    </section>
@endsection
