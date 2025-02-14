<div>
    <x-slot name="header">
        Velkommen!
    </x-slot>

    <div>
        <x-main-container>
            <div class="p-10">
                <p class="mb-4">
                    For at se fakturaer relateret til Dansk Speedcubing Forening (DSF) skal du være logget ind.
                </p>
                <a href="/auth/wca/redirect">
                    <x-bladewind::button>
                        Log ind med WCA
                        <x-wca-logo class="ml-2 inline-block" width="25" height="25"/>
                    </x-bladewind::button>
                </a>
            </div>
        </x-main-container>
    </div>
</div>
