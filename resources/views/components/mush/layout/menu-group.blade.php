@props([
  'title',
])
<div class="mb-6">
    <div class="mb-2">
        <p class="text-sm text-gray-400 mt-2">{{ $title }}</p>
    </div>
    <div>
        {{ $slot }}
    </div>
</div>
