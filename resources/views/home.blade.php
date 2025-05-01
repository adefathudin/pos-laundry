@include('_layouts.header')


@include('_layouts.leftbar')

@if (Auth::check())
@if (Auth::user()->role === 'admin')
@include('_modules.dashboard.index')
@elseif (Auth::user()->role === 'user')
@include('_modules.kasir.index')
@endif
@endif