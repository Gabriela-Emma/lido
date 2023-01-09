<x-errors-layout class="errors">
        <div class="flex-shrink-0 my-auto py-16 sm:py-32">
            <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">404 error</p>
            <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Page not found</h1>
            <p class="mt-2 text-base text-gray-500">This is all we know.</p>
            <div class="mt-6">
                <a href="{{url(config('app.url'))}}" class="text-base font-medium text-indigo-600 hover:text-indigo-500">Go back home<span aria-hidden="true"> &rarr;</span></a>
            </div>
        </div>
</x-errors-layout>
{{--@extends('errors::minimal')--}}

{{--@section('title', __('Not Found'))--}}
{{--@section('code', '404')--}}
{{--@section('message', __('Not Found'))--}}
