@extends('layouts.app')

@section('pageHeadInclude')
<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0.5;
}
</style>
@endsection

@section('content')
<transition name="fade" mode="out-in">
<router-view></router-view>
</transition>

@endsection
