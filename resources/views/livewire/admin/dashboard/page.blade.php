<div class="space-y-6">
    <!-- Dashboard Header -->
    <div class="flex justify-between items-center">
        <div>
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Dashboard
            </flux:heading>
            <p class="text-sm text-zinc-600 mt-1">
                Bienvenido al panel de administración de Casa Gallina
            </p>
        </div>
        <div class="text-sm text-zinc-500">
            {{ now()->format('d M Y, H:i') }}
        </div>
    </div>

    <!-- Key Metrics Cards - Row 1: Content Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Programas -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Programas</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalProgramas }}</p>
                    <p class="text-xs text-zinc-500 mt-1">
                        <span class="text-green-600">{{ $this->activeProgramas }}</span> activos
                    </p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.calendar-days class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>

        <!-- Active Exposiciones -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Exposiciones</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalExposiciones }}</p>
                    <p class="text-xs text-zinc-500 mt-1">
                        <span class="text-green-600">{{ $this->activeExposiciones }}</span> activas
                    </p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.photo class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>

        <!-- Noticias This Month -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Noticias</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalNoticias }}</p>
                    <p class="text-xs text-zinc-500 mt-1">
                        <span class="text-blue-600">{{ $this->noticiasThisMonth }}</span> este mes
                    </p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.newspaper class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>

        <!-- Total Publicaciones -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Publicaciones</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalPublicaciones }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Total publicadas</p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.document-text class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Key Metrics Cards - Row 2: Engagement Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Newsletter Subscribers -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Suscriptores</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalSubscribers }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Newsletter</p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.envelope class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>

        <!-- Monthly Donations -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Donaciones</p>
                    <p class="text-2xl font-bold text-forest-800">${{ number_format($this->monthlyDonations, 0) }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Este mes</p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.credit-card class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>

        <!-- Team Members -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Miembros</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalMiembros }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Del equipo</p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.user-group class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>

        <!-- Collaboration Spaces -->
        <flux:card class="!p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-600">Espacios</p>
                    <p class="text-2xl font-bold text-forest-800">{{ $this->totalEspacios }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Colaboración</p>
                </div>
                <div class="p-3 bg-forest-100 rounded-lg">
                    <flux:icon.building-library class="w-6 h-6 text-forest-600" />
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Left Column: Recent Activity Tables (60% width) -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Recent News -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <flux:heading size="lg" class="!text-forest-800 font-serif">
                        Noticias Recientes
                    </flux:heading>
                    <flux:button size="sm" variant="ghost" href="/admin/noticias" class="!text-forest-600">
                        Ver todas
                        <flux:icon.arrow-right class="w-4 h-4 ml-1" />
                    </flux:button>
                </div>
                
                <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
                    <flux:table class="!text-sm">
                        <flux:table.columns>
                            <flux:table.column>Título</flux:table.column>
                            <flux:table.column>Estado</flux:table.column>
                            <flux:table.column>Fecha</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @forelse ($this->recentNoticias as $noticia)
                                <flux:table.row :key="$noticia->id" class="group hover:bg-zinc-50 cursor-pointer" 
                                    onclick="window.location.href='/admin/noticias'">
                                    <flux:table.cell>
                                        <span class="group-hover:underline">
                                            {{ $noticia->titulo }}
                                        </span>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge size="sm" 
                                            :color="$noticia->activo ? 'green' : 'yellow'">
                                            {{ $noticia->activo ? 'Publicada' : 'Borrador' }}
                                        </flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell class="text-zinc-500">
                                        {{ $noticia->created_at->format('d M') }}
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="3" class="text-center text-zinc-500">
                                        No hay noticias recientes
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>
            </div>

            <!-- Recent Programs -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <flux:heading size="lg" class="!text-forest-800 font-serif">
                        Programas Recientes
                    </flux:heading>
                    <flux:button size="sm" variant="ghost" href="/admin/programa" class="!text-forest-600">
                        Ver todos
                        <flux:icon.arrow-right class="w-4 h-4 ml-1" />
                    </flux:button>
                </div>
                
                <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
                    <flux:table class="!text-sm">
                        <flux:table.columns>
                            <flux:table.column>Título</flux:table.column>
                            <flux:table.column>Categoría</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @forelse ($this->recentProgramas as $programa)
                                <flux:table.row :key="$programa->id" class="group hover:bg-zinc-50 cursor-pointer" 
                                    onclick="window.location.href='/admin/programa'">
                                    <flux:table.cell>
                                        <span class="group-hover:underline">
                                            {{ $programa->titulo }}
                                        </span>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($programa->tags->first())
                                            <flux:badge size="sm" color="blue">
                                                {{ $programa->tags->first()->nombre }}
                                            </flux:badge>
                                        @else
                                            <span class="text-zinc-400 text-xs">Sin categoría</span>
                                        @endif
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="3" class="text-center text-zinc-500">
                                        No hay programas recientes
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>
            </div>
        </div>

        <!-- Right Column: Quick Access & Status (40% width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Recent Donations -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <flux:heading size="lg" class="!text-forest-800 font-serif">
                        Donaciones Recientes
                    </flux:heading>
                    <flux:button size="sm" variant="ghost" href="/admin/donaciones" class="!text-forest-600">
                        Ver todas
                        <flux:icon.arrow-right class="w-4 h-4 ml-1" />
                    </flux:button>
                </div>
                
                <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
                    <flux:table class="!text-sm">
                        <flux:table.columns>
                            <flux:table.column>Donante</flux:table.column>
                            <flux:table.column>Monto</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @forelse ($this->recentDonaciones as $donacion)
                                <flux:table.row :key="$donacion->id" class="group hover:bg-zinc-50 cursor-pointer" 
                                    onclick="window.location.href='/admin/donaciones'">
                                    <flux:table.cell>
                                        <div>
                                            <div class="group-hover:underline font-medium">
                                                {{ $donacion->donador ? Str::limit($donacion->donador->name, 20) : 'Anónimo' }}
                                            </div>
                                            <div class="text-xs text-zinc-500">
                                                {{ $donacion->created_at->format('d M') }}
                                            </div>
                                        </div>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <span class="font-medium text-forest-700">
                                            ${{ number_format($donacion->amount, 0) }}
                                        </span>
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="2" class="text-center text-zinc-500">
                                        No hay donaciones recientes
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>
            </div>


            <!-- Upcoming Events -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <flux:heading size="lg" class="!text-forest-800 font-serif">
                        Próximos Eventos
                    </flux:heading>
                </div>
                
                <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
                    @forelse ($this->upcomingEvents as $event)
                        <div class="flex items-center justify-between py-3 border-b border-zinc-100 last:border-b-0 hover:bg-zinc-50 cursor-pointer rounded transition-colors"
                             onclick="window.location.href='{{ $event->route }}'">
                            <div class="flex-1">
                                <div class="font-medium text-sm hover:underline">
                                    {{ Str::limit(strip_tags($event->titulo), 30) }}
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <flux:badge size="sm" color="blue">{{ $event->type }}</flux:badge>
                                    <span class="text-xs text-zinc-500">
                                        {{ $event->fecha ?? $event->date->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                            <flux:icon.chevron-right class="w-4 h-4 text-zinc-400" />
                        </div>
                    @empty
                        <div class="text-center text-zinc-500 py-8">
                            <flux:icon.calendar class="w-8 h-8 text-zinc-400 mx-auto mb-2" />
                            <p class="text-sm">No hay eventos próximos</p>
                        </div>
                    @endforelse
                </flux:card>
            </div>
        </div>
    </div>
</div>