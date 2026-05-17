@props(['content', 'class' => ''])

<div class="prose prose-sm max-w-none {{ $class }}"
     style="--tw-prose-headings: rgb(15 23 42); --tw-prose-links: rgb(37 99 235); --tw-prose-code: rgb(239 68 68);">
    {!! Str::markdown(e($content)) !!}
</div>
