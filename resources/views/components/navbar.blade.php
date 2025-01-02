<nav x-data="{ open: false, profileOpen: false }" class="relative px-4 mx-auto max-w-7xl sm:px-6 z-[15] bg-transparent">
    <div class="pt-4 pb-4 sm:pb-3">
        <nav class="relative flex items-center justify-between sm:h-10 md:justify-center bg-transparent"
            aria-label="Global">
            <div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
                <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="/">
                        <img src="{{ asset('img/logoskysense.png') }}" alt="SkySense" class="h-24 w-auto">
                    </a>
                    <div class="flex items-center -mr-2 md:hidden">
                        <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 text-gray-400 bg-transparent rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-50"
                            type="button" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" aria-hidden="true" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="hidden md:flex md:space-x-10 list-none">
                <li>
                    <a href="/blog" class="text-base font-normal text-neutral-500 list-none hover:text-neutral-900"
                        target="">Blog</a>
                </li>
                @auth
                    <li>
                        <a href="/livedata" class="text-base font-normal text-neutral-500 list-none hover:text-neutral-900"
                            target="">Live Data
                        </a>
                    </li>
                    <li>
                        <a href="/wardrobe"
                            class="text-base font-normal text-neutral-500 list-none hover:text-neutral-900">Wardrobe
                        </a>
                    </li>
                @endauth
            </div>
            <div class="hidden md:absolute md:flex md:items-center md:justify-end md:inset-y-0 md:right-0">
                <div class="inline-flex rounded-full shadow">
                    @guest
                        <a href="/signin"
                            class="inline-flex items-center px-4 py-2 text-base text-neutral-900 bg-transparent border border-transparent rounded-full cursor-pointer font-base hover:bg-gray-200">
                            Sign in
                        </a>
                    @else
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen" class="flex items-center">
                                <img src="{{ Auth::user()->avatar_url }}" alt="avatar" class="w-10 h-10 rounded-full">
                            </button>
                            <div x-show="profileOpen" @click.away="profileOpen = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 w-48 py-2 mt-2 bg-white rounded-lg shadow-xl z-[15]">
                                <a href="/settings"
                                    class="block px-4 py-2 text-sm text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">User
                                    Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="absolute top-16 left-0 right-0 bg-white shadow-lg rounded-lg mt-2 w-full md:hidden z-[999]">
            <ul class="list-none py-2">
                <li>
                    <a href="/blog"
                        class="block px-4 py-2 text-base font-normal text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">Blog</a>
                </li>

                @auth
                    <li>
                        <a href="/livedata"
                            class="block px-4 py-2 text-base font-normal text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">Live
                            Data</a>
                    </li>
                    <li>
                        <a href="/wardrobe"
                            class="block px-4 py-2 text-base font-normal text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">Wardrobe</a>
                    </li>
                @endauth

                @guest
                    <li>
                        <a href="/signin"
                            class="block px-4 py-2 text-base font-normal text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">Sign
                            in</a>
                    </li>
                @endguest
                @auth
                    <li>
                        <a href="/settings"
                            class="block px-4 py-2 text-base font-normal text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">User
                            Settings</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-neutral-500 hover:bg-blue-50 hover:text-neutral-900 transition-colors duration-150">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
