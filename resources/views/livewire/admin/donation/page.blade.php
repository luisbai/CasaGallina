<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <flux:heading size="xl" class="!text-forest-800 font-serif">
            Donaciones
        </flux:heading>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Donations -->
        <flux:card class="!px-4 !py-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Donaciones</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($this->totalDonations, 2) }}</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </flux:card>

        <!-- This Month Donations -->
        <flux:card class="!px-4 !py-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Este Mes</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($this->thisMonthDonations, 2) }}</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </flux:card>

        <!-- Total Donors -->
        <flux:card class="!px-4 !py-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200" onclick="document.getElementById('donadores-section').scrollIntoView({behavior: 'smooth'})">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Donadores</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($this->totalDonors) }}</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </flux:card>

        <!-- Recent Donations -->
        <flux:card class="!px-4 !py-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Últimos 7 días</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($this->recentDonationsCount) }}</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Left Column - Donaciones -->
        <div class="md:col-span-7">
            <div class="flex justify-between items-center mb-4">
                <flux:heading size="xl" class="!text-forest-800 font-serif">
                    Donaciones
                </flux:heading>
            </div>

            <!-- Filters -->
            <flux:card class="!px-4 !py-4 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <flux:input 
                        placeholder="Buscar donador o noticia..." 
                        wire:model.live="search" 
                        size="sm" 
                        icon="magnifying-glass" 
                    />

                    <!-- Status Filter -->
                    <flux:select 
                        wire:model.live="statusFilter" 
                        placeholder="Estado" 
                        size="sm"
                    >
                        <flux:select.option value="">Todos los estados</flux:select.option>
                        <flux:select.option value="pending">Pendiente</flux:select.option>
                        <flux:select.option value="completed">Completada</flux:select.option>
                        <flux:select.option value="failed">Fallida</flux:select.option>
                        <flux:select.option value="refunded">Reembolsada</flux:select.option>
                    </flux:select>

                    <!-- Origen Filter -->
                    <flux:select 
                        wire:model.live="noticiaFilter" 
                        placeholder="Origen" 
                        size="sm"
                    >
                        <flux:select.option value="">Todos los orígenes</flux:select.option>
                        <flux:select.option value="general">General</flux:select.option>
                        @foreach($this->availableNoticias as $noticia)
                            <flux:select.option value="{{ $noticia->id }}">
                                {{ \Str::limit(strip_tags($noticia->titulo), 30) }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </flux:card>

            <!-- Donations Table -->
            <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
                <flux:table :paginate="$this->donaciones">
                    <flux:table.columns>
                        <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Fecha</flux:table.column>
                        <flux:table.column>Donador</flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'amount'" :direction="$sortDirection" wire:click="sort('amount')">Cantidad</flux:table.column>
                        <flux:table.column>Origen</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($this->donaciones as $donacion)
                            <flux:table.row :key="$donacion->id">
                                <flux:table.cell>
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $donacion->created_at->diffForHumans() }}</div>
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $donacion->donador->name }}</div>
                                        <div class="text-gray-500">{{ $donacion->donador->email }}</div>
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span class="font-bold text-base text-green-600">
                                        ${{ number_format($donacion->amount, 2) }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <div class="text-sm">
                                        @if($donacion->noticia)
                                            <flux:tooltip content="{{ strip_tags($donacion->noticia->titulo) }}">
                                                <span class="cursor-help">{{ \Str::limit(strip_tags($donacion->noticia->titulo), 40) }}</span>
                                            </flux:tooltip>
                                        @else
                                            <flux:tooltip content="Donación general no asociada a una noticia específica">
                                                <span class="cursor-help">General</span>
                                            </flux:tooltip>
                                        @endif
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="4" class="text-center">
                                    No hay donaciones registradas
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        <!-- Right Column - Donadores -->
        <div class="md:col-span-5">
            <div class="flex justify-between items-center mb-4">
                <flux:heading size="xl" class="!text-forest-800 font-serif">
                    Donadores
                </flux:heading>
            </div>

            <div class="flex items-center justify-between mb-4 gap-4">
                <flux:input placeholder="Buscar donador..." wire:model.live="donorSearch" size="sm" icon="magnifying-glass" />
            </div>

            <!-- Donadores Table -->
            <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm" id="donadores-section">
                <flux:table :paginate="$this->donadores" :show-summary="false">
                    <flux:table.columns>
                        <flux:table.column sortable :sorted="$donorSortBy === 'name'" :direction="$donorSortDirection" wire:click="sortDonors('name')">Nombre</flux:table.column>
                        <flux:table.column sortable :sorted="$donorSortBy === 'total_amount'" :direction="$donorSortDirection" wire:click="sortDonors('total_amount')">Total</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($this->donadores as $donador)
                            <flux:table.row :key="$donador->id">
                                <flux:table.cell>
                                    <div class="text-sm">
                                        <div class="font-medium break-words">{{ Str::limit($donador->name, 25) }}</div>
                                        <div class="text-gray-500 text-xs break-all">{{ Str::limit($donador->email, 30) }}</div>
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span class="font-bold text-lg text-green-600">
                                        ${{ number_format($donador->total_amount ?? 0, 2) }}
                                    </span>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="2" class="text-center">
                                    No hay donadores registrados
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>
    </div>
</div>