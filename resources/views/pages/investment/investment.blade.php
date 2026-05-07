@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Investment" />
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12">
            <x-investment.top-summary :datas="$datas"/>
            {{-- <x-ecommerce.ecommerce-metrics /> --}}
        </div>
    </div>
@endsection
