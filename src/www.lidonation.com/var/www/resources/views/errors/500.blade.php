<x-errors-layout class="errors">
    <div class="flex-shrink-0 my-auto py-16 sm:py-32">
        <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide">500 error</p>
        <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Server Error</h1>
        <p class="mt-2 text-base text-gray-500">{{$exception->getMessage()}}</p>
        <div class="mt-6">
            <a href="{{route('home')}}" class="text-base font-medium text-indigo-600 hover:text-indigo-500">Go back home<span aria-hidden="true"> &rarr;</span></a>
        </div>
    </div>
</x-errors-layout>
{{--@extends('errors::minimal')--}}

{{--@section('title', __('Server Error'))--}}
{{--@section('code', '500')--}}
{{--@section('message', __('Server Error'))--}}
