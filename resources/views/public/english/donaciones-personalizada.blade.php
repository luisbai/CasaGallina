@extends('layouts.english.boilerplate')

@section('content')
    <div id="donaciones-index">
        <section id="donaciones-banner">
            <div class="position-relative">
                <img src="/assets/images/donaciones/banner-thin.jpg" class="img-fluid">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="donaciones-title">
                                <h1>Personalized Donation - Bank Transfer</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="donaciones-iconos">
            <div class="container">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-4">
                    <div class="p-4 bg-forest-100 rounded h-full flex flex-col">
                        <h2 class="!text-xl font-libre !font-semibold text-forest-600 mb-2">Personalized donation</h2>
                        <p class="!text-base !text-gray-700 flex-grow">If you prefer to make a bank transfer or deposit, here you will find all the necessary information to make your donation.</p>
                    </div>
                    <div class="p-4 bg-forest-100 rounded h-full flex flex-col">
                        <h3 class="!text-xl font-libre !font-semibold text-forest-600 mb-2">Rewards</h3>
                        <ul class="!text-base !text-gray-700 space-y-2 flex-grow">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-forest-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Four-monthly digital newsletter</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-forest-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Mention on website</span>
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 bg-forest-100 rounded h-full flex flex-col">
                        <h4 class="!text-xl font-libre !font-semibold text-forest-600 mb-2">Why bank transfer?</h4>
                        <p class="!text-base !text-gray-700 mb-0 flex-grow">100% of your donation reaches Casa Gallina directly without commissions. You can donate any amount safely and receive an official bank receipt.</p>
                    </div>
                </div>

                <!-- Additional information section -->
                <div class="text-center pb-5">
                    <div class="bg-forest-200 rounded p-6 mb-4">
                        <p class="text-forest-900 mb-0 ">All donations starting from USD $2,500.00 receive: access to an annual experience and an annual calendar</p>
                    </div>
                    <p class="text-gray-700 !text-sm">If you have questions or would like more information, contact us at <a href="mailto:dona@casagallina.org.mx" class="!text-forest-600 hover:text-forest-700">dona@casagallina.org.mx</a> or call <a href="tel:+525526302601" class="!text-forest-600 hover:text-forest-700">5526302601</a> and we will be happy to assist you.</p>
                </div>
            </div>
        </section>

        <!-- Bank Information Section -->
        <section class="py-20 bg-green-800">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                        <div class="flex flex-col rounded-xl overflow-hidden donation-section">
                            <div class="relative h-[450px] bg-green-600 overflow-hidden">
                                <img src="{{ asset('assets/images/donaciones/modal-bg4.jpg') }}" alt="Personalized donation" class="w-full h-full object-cover">
                            </div>
                            <div class="donation-content p-6 bg-white">
                                <h3 class="text-xl font-bold text-green-600 mb-3">Your personalized donation matters</h3>
                                <p class="text-gray-700">Bank transfers allow us to receive 100% of your donation without commissions, maximizing the impact of your support.</p>
                            </div>
                        </div>

                        <!-- Right side - Bank Information -->
                        <div class="bg-white p-8 rounded-xl shadow-lg">
                            <h2 class="text-lg font-bold text-green-600 mb-6 font-libre !tracking-tight">Banking Information</h2>
                            <div class="space-y-4 mb-6">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-bold text-gray-800 mb-2">Beneficiary</h4>
                                    <p class="text-gray-700">Casa Gallina A.C.</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-bold text-gray-800 mb-2">Bank</h4>
                                    <p class="text-gray-700">BBVA México</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-bold text-gray-800 mb-2">Account Number</h4>
                                    <p class="text-gray-700 font-mono text-lg">0123456789</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-bold text-gray-800 mb-2">CLABE</h4>
                                    <p class="text-gray-700 font-mono text-lg">012345678901234567</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-english.donation-info-gallery />
    </div>
@endsection