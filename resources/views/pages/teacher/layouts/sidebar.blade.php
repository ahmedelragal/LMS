{{-- @section('title')
     {{ $stage->name }}
@endsection --}}

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => 'teacher.dashboard'],
        ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => 'teacher.Assignment'],
    ];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection
