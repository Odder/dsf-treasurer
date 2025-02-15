<div>
    <table class="w-full">
        <thead class="text-left uppercase text-xs tracking-widest bg-gray-800">
        {{ $header }}
        </thead>
        <tbody class="bg-gray-700 text-sm">
        {{ $body }}
        </tbody>
    </table>
    <div class="w-full bg-gray-800 min-h-4">
        @if(isset($footer))
            {{ $footer }}
        @endif
    </div>
</div>
