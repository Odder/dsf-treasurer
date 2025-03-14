<aside
    class="fixed top-0 md:flex md:w-64 bg-gray-800 text-white  dark:text-gray-300 py-6 px-3 flex-shrink-0 flex flex-col h-screen">
    <nav>
        <div class="w-full mb-4">
            <img src="{{ asset('images/dsf_logo.png') }}" class="block mx-auto" width="100px" height="100px"/>
        </div>

        @auth
            <x-mush.layout.menu-item title="Dashboard" link="/dashboard" match="dashboard"/>

            @if($user?->isMemberOfAssociation())
                <x-mush.layout.menu-group title="Afregning">
                    <x-mush.layout.menu-item title="Fakturaer" link="/invoices" match="invoices"/>
                </x-mush.layout.menu-group>
            @endif
            <x-mush.layout.menu-group title="Konkurrencer">
                <x-mush.layout.menu-item title="Konkurrencer" link="/competitions" match="competitions*"/>
            </x-mush.layout.menu-group>
            <x-mush.layout.menu-group title="Foreninger">
                <x-mush.layout.menu-item title="Regionale foreninger" link="/regional-associations"
                                         match="regional-associations"/>
                @if($contact)
                    @foreach($contact?->associations as $association)
                        <x-mush.layout.menu-item :title="$association->name"
                                                 link="/regional-associations/{{ $association->id }}"
                                                 match="regional-associations/{{ $association->id }}"/>
                    @endforeach
                @endif
            </x-mush.layout.menu-group>
            <x-mush.layout.menu-group title="Udlæg">
                <x-mush.layout.menu-item title="Opret udlæg" link="/receipts/upload" match="receipts/upload"/>
                <x-mush.layout.menu-item title="Mine Udlæg" link="/me/receipts" match="me/receipts"/>
                @if($user?->isDSFBoardMember())
                    <x-mush.layout.menu-item title="Administrer Udlæg" link="/manage/receipts" match="manage/receipts"/>
                @endif
            </x-mush.layout.menu-group>

            @if($user?->isDSFBoardMember())
                <x-mush.layout.menu-group title="Admin">
                    <x-mush.layout.menu-item title="Roller" link="/people" match="people*"/>
                    <x-mush.layout.menu-item title="Søg Kontingent" link="/membership-fees/search" match="membership-fees/search"/>
                </x-mush.layout.menu-group>
            @endif
        @else
            <x-mush.layout.menu-group title="Bruger">
                <x-mush.layout.menu-item title="Log ind" link="/login" match="login"/>
            </x-mush.layout.menu-group>
        @endif
    </nav>
</aside>
