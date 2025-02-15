@props([
  'title',
  'link',
  'match',
])

<div>
    <a href="{{ $link }}"
       wire:navigate.hover @class(['block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white', request()->is($match) ? 'bg-gray-700' : ''])>
        {{ $title }}
    </a>
</div>
