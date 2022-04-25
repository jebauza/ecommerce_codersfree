<header class="bg-gray-700">
    <div class="container flex items-center h-16">
        <a class="flex flex-col items-center justify-center h-full px-4 font-semibold text-white bg-white bg-opacity-25 cursor-pointer">
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <span>Categorías</span>
        </a>

        <a href="/" class="mx-6">
            <x-jet-application-mark class="block w-auto h-9" />
        </a>

        @livewire('search')

        <div class="relative ml-3">
            @auth

            <x-jet-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                        <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </button>
                </x-slot>

                <x-slot name="content">
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Account') }}
                    </div>

                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                        {{ __('Profile') }}
                    </x-jet-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-jet-dropdown-link href="{{ route('logout') }}"
                                 @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-jet-dropdown-link>
                    </form>
                </x-slot>
            </x-jet-dropdown>

            @else

            <x-jet-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <i class="text-3xl text-white cursor-pointer fa fa-user-circle"></i>
                </x-slot>

                <x-slot name="content">
                    <x-jet-dropdown-link href="{{ route('login') }}">
                        {{ __('Login') }}
                    </x-jet-dropdown-link>

                    <x-jet-dropdown-link href="{{ route('register') }}">
                        {{ __('Register') }}
                    </x-jet-dropdown-link>

                </x-slot>
            </x-jet-dropdown>

            @endauth
        </div>

    </div>
</header>
