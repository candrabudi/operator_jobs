@php
    $platforms = [
        'Instagram' => [
            'icon' => 'https://cdn-icons-png.flaticon.com/512/2504/2504918.png',
            'bg_class' => 'bg-warning-subtle text-warning',
        ],
        'Youtube' => [
            'icon' => 'https://cdn-icons-png.flaticon.com/512/2504/2504965.png',
            'bg_class' => 'bg-info-subtle text-info',
        ],
        'Twitter' => [
            'icon' => 'https://cdn-icons-png.flaticon.com/512/2504/2504903.png',
            'bg_class' => 'bg-danger-subtle text-danger',
        ],
        'Tiktok' => [
            'icon' => 'https://cdn-icons-png.flaticon.com/512/2504/2504942.png',
            'bg_class' => 'bg-success-subtle text-success',
        ],
        'Facebook' => [
            'icon' => 'https://cdn-icons-png.flaticon.com/512/2504/2504903.png',
            'bg_class' => 'bg-success-subtle text-success',
        ],
    ];
@endphp
@foreach ($socialMediaPlatforms as $smp)
    @php
        $platform = $platforms[$smp->social_media_name] ?? null;
    @endphp
    @if ($platform)
        <div class="col-lg-4">
            <div class="card shadow-sm p-3 border-0 rounded">
                <div class="row align-items-center">
                    <div class="col-3">
                        <div class="{{ $platform['bg_class'] }} text-center py-2 rounded-1">
                            <img src="{{ $platform['icon'] }}" style="width: 50px;"
                                alt="{{ $smp->social_media_name }} Icon">
                        </div>
                    </div>
                    <div class="col-9">
                        <div>
                            <h5 class="card-title mb-1">{{ $smp->social_media_name }}</h5>
                            <p class="text-muted mb-0">{{ count($smp->requestPost) }} Total Requests Posting</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@foreach ($socialMediaPlatforms as $smp)
    @php
        $platform = $platforms[$smp->social_media_name] ?? null;
    @endphp
    @if ($platform)
        <div class="col-lg-4">
            <div class="card shadow-sm p-3 border-0 rounded">
                <div class="row align-items-center">
                    <div class="col-3">
                        <div class="{{ $platform['bg_class'] }} text-center py-2 rounded-1">
                            <img src="{{ $platform['icon'] }}" style="width: 50px;"
                                alt="{{ $smp->social_media_name }} Icon">
                        </div>
                    </div>
                    <div class="col-9">
                        <div>
                            <h5 class="card-title mb-1">{{ $smp->social_media_name }}</h5>
                            <p class="text-muted mb-0">{{ count($smp->requestBoost) }} Total Requests Boosting</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
