@extends('layouts.app')

@section('content')

<div class="text-[13px] leading-[20px] flex-1 p-6 pb-6 lg:p-20 lg:pb-10 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
    <span>
        Read the
        <a href="https://laravel.com/docs" target="_blank" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433] ml-1">
            <span>Documentation</span>
            <svg
                width="10"
                height="11"
                viewBox="0 0 10 11"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="w-2.5 h-2.5"
            >
                <path
                    d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001"
                    stroke="currentColor"
                    stroke-linecap="square"
                />
            </svg>
        </a>
    </span>
</div>
@endsection
