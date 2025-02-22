<div>
    <x-slot:header>
        Velkommen!
    </x-slot:header>

    <x-mush.layout.container>
        <div></div>
        <x-mush.comp.card title="Hej! 👋">
            <div class="p-4">
                <p class="mb-4">
                    Log ind for at få adgang til DSF's kontigent system. Her kan du:
                </p>
                <ul class="list-disc pl-5 mb-4">
                    <li>Se og administrere fakturaer for din forening.</li>
                    <li>Oprette og følge dine DSF udlæg.</li>
                    <li>Se kommende konkurrencer.</li>
                </ul>
                <p class="mb-4">
                    Du logger ind med din WCA profil.
                </p>
                <a href="/auth/wca/redirect">
                    <x-bladewind::button>
                        Log ind med WCA
                        <x-wca-logo class="ml-2 inline-block" width="25" height="25"/>
                    </x-bladewind::button>
                </a>
            </div>
        </x-mush.comp.card>
    </x-mush.layout.container>
</div>
