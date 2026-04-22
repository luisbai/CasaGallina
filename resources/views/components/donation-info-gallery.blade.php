<section id="donaciones-info">
    <div class="container mx-auto px-4 pt-16">
        <!-- Ribbon-style title (full width) -->
        <div class="text-center border-b-2 border-green-600 pb-1.5 md:pb-2 mb-6">
            <span class="bg-green-600 px-8 py-2 text-white font-serif text-xl md:text-2xl leading-4">
                ¿En qué se invierte tu donación?
            </span>
        </div>

        <!-- Intro text (full width, green) -->
        <div class="font-serif text-green-600 text-xl leading-6 px-4 md:px-16 pb-12 text-center">
            Los programas de <strong>Casa Gallina</strong> favorecen la construcción de redes locales, brindando acceso a herramientas para el cambio sostenible, la participación social y la resiliencia.
        </div>

        <!-- Two-column layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Gallery Column (Left) -->
            <div class="w-full" x-data="{
                currentImageIndex: 0,
                totalImages: 3,
                autoplayInterval: null,
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.currentImageIndex = this.currentImageIndex < this.totalImages - 1 ? this.currentImageIndex + 1 : 0;
                    }, 4000);
                },
                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                        this.autoplayInterval = null;
                    }
                }
            }"
            x-init="startAutoplay()"
            @mouseenter="stopAutoplay()"
            @mouseleave="startAutoplay()">
                <div class="relative h-80 w-full overflow-hidden group rounded-lg shadow-md">
                    <!-- Images Container -->
                    <div class="relative w-full h-full">
                        <!-- Image 1 -->
                        <div class="absolute inset-0 transition-opacity duration-300"
                             x-show="currentImageIndex === 0"
                             x-transition:enter="transition-opacity duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <img src="{{ asset('assets/images/donaciones/gallery-1.jpg') }}"
                                 alt="Programas Casa Gallina - Imagen 1"
                                 class="w-full h-full object-cover transition-transform duration-300"
                                 loading="lazy">
                        </div>

                        <!-- Image 2 -->
                        <div class="absolute inset-0 transition-opacity duration-300"
                             x-show="currentImageIndex === 1"
                             x-transition:enter="transition-opacity duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <img src="{{ asset('assets/images/donaciones/gallery-2.jpg') }}"
                                 alt="Programas Casa Gallina - Imagen 2"
                                 class="w-full h-full object-cover transition-transform duration-300"
                                 loading="lazy">
                        </div>

                        <!-- Image 3 -->
                        <div class="absolute inset-0 transition-opacity duration-300"
                             x-show="currentImageIndex === 2"
                             x-transition:enter="transition-opacity duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <img src="{{ asset('assets/images/donaciones/gallery-3.jpg') }}"
                                 alt="Programas Casa Gallina - Imagen 3"
                                 class="w-full h-full object-cover transition-transform duration-300"
                                 loading="lazy">
                        </div>
                    </div>

                    <!-- Navigation Controls (visible on hover) -->
                    <div class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                        <!-- Previous Button -->
                        <button @click="currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1"
                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <!-- Next Button -->
                        <button @click="currentImageIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0"
                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Image Counter -->
                    <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span x-text="currentImageIndex + 1"></span>/<span x-text="totalImages"></span>
                    </div>
                </div>
            </div>

            <!-- Info Column (Right) -->
            <div class="w-full">
                <!-- Second intro text (green serif) -->
                <div class="font-serif text-gray-600 text-lg leading-6 mb-4">
                    Casa Gallina permanentemente desarrolla actividades y procesos creativos sobre sustentabilidad y ecología, que implican:
                </div>

                <!-- List with SVG checkmarks -->
                <div class="space-y-1">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Producción de materiales educativos</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Programas de capacitación y manuales de implementación educativos para docentes</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Talleres</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Intervenciones artísticas en escuelas públicas</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Proyectos artísticos</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Exposiciones</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-serif text-gray-600 text-base leading-6">Proyectos visuales de participación comunitaria</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>