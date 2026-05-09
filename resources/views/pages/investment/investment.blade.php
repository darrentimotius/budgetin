@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Investment" />

    <div x-data="{ tab: 'allocation' }">
        <x-investment.top-summary :datas="$datas" />

        <div class="mt-8 flex flex-col gap-4 lg:flex-row lg:justify-between lg:items-center">
            <div class="flex gap-10 overflow-x-auto whitespace-nowrap no-scrollbar ">
                <button @click="tab='allocation'"
                    :class="tab === 'allocation' ? 'border-b-2 border-main text-main' : 'text-gray-500 dark:text-gray-400'"
                    class="pb-2 text-theme-sm font-medium transition-colors duration-300">
                    Allocation
                </button>
                <button @click="tab='history'"
                    :class="tab === 'history' ? 'border-b-2 border-main text-main' : 'text-gray-500 dark:text-gray-400'"
                    class="pb-2 text-theme-sm font-medium transition-colors duration-300">
                    History
                </button>
            </div>
            <div class="grid grid-cols-2 gap-2 lg:flex lg:w-auto">
                <button @click="openCreateModal()"
                    class="w-full lg:w-auto whitespace-nowrap justify-center inline-flex items-center gap-3 rounded-lg border border-gray-300 bg-white/90 px-4 py-2 text-theme-xs md:text-theme-sm font-medium text-gray-800 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white dark:hover:bg-white/[0.07] dark:hover:text-white/90">
                    <i data-lucide="plus" class="w-3 h-3 md:w-4 md:h-4 shrink-0 text-gray-800 dark:text-white"></i>
                    Add Investment
                </button>
                <button @click="openCreateModal()"
                    class="w-full lg:w-auto whitespace-nowrap justify-center inline-flex items-center gap-3 rounded-lg border border-gray-300 bg-main px-4 py-2 text-theme-xs md:text-theme-sm font-medium text-white shadow-theme-xs hover:bg-main-hover hover:text-white/90 dark:border-gray-700 dark:bg-main dark:text-white dark:hover:bg-main-hover dark:hover:text-white/90">
                    <i data-lucide="pencil-line" class="w-3 h-3 md:w-4 md:h-4 shrink-0 text-white dark:text-white"></i>
                    Record Investment
                </button>
            </div>
        </div>

        <div class="mt-4">
            <div x-show="tab === 'allocation'">
                <x-investment.allocation.allocation :datas="$datas" />
            </div>
            <div x-show="tab === 'history'">
                Transaction History content goes here...
            </div>
        </div>
    </div>
@endsection
