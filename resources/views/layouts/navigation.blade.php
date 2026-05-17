<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-slate-900">
                <img src="{{ asset('images/logo.png') }}" alt="RiskGuard TI"
                     class="h-9 w-9 rounded-lg object-cover">
                <span class="text-lg font-semibold">{{ config('app.name', 'Gestión de Riesgos TI') }}</span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>
                <x-nav-link :href="route('matriz.index')" :active="request()->routeIs('matriz.index')">
                    Matriz
                </x-nav-link>
                <x-nav-link :href="route('activos.index')" :active="request()->routeIs('activos.*')">
                    Activos
                </x-nav-link>
                <x-nav-link :href="route('amenazas.index')" :active="request()->routeIs('amenazas.*')">
                    Amenazas
                </x-nav-link>
                <x-nav-link :href="route('evaluaciones.index')" :active="request()->routeIs('evaluaciones.*')">
                    Evaluaciones
                </x-nav-link>
                <x-nav-link :href="route('mitigacion.index')" :active="request()->routeIs('mitigacion.*')">
                    Mitigación
                </x-nav-link>
                <x-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.index')">
                    Bitácora
                </x-nav-link>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <span class="text-sm text-slate-600">{{ Auth::user()->name }}</span>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500">
                            {{ Auth::user()->name }}
                            <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="space-y-1 px-4 py-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('matriz.index')" :active="request()->routeIs('matriz.index')">Matriz</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('activos.index')" :active="request()->routeIs('activos.*')">Activos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('amenazas.index')" :active="request()->routeIs('amenazas.*')">Amenazas</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('evaluaciones.index')" :active="request()->routeIs('evaluaciones.*')">Evaluaciones</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mitigacion.index')" :active="request()->routeIs('mitigacion.*')">Mitigación</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.index')">Bitácora</x-responsive-nav-link>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            <div class="space-y-1">
                <div class="text-sm font-medium text-slate-900">{{ Auth::user()->name }}</div>
                <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
