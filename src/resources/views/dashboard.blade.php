@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    ログインが完了しました

                    <!-- アプリへのリンク -->
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="text-blue-500 underline">
                            勤怠管理アプリ Atteへ移動
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
