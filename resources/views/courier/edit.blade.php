<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Courier
        </h2>
    </x-slot>

    <div class="bg">
        <div class="py-12 bg-grey min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-partials.card>
                    <x-slot name="title">
                        <a href="{{ route('courier.index') }}" class="mr-4"
                            ><i class="mr-1 icon ion-md-arrow-back"></i
                        ></a>
                    </x-slot>

                    <x-form
                        method="PUT"
                        action="{{ route('courier.update', $courier) }}"
                        class="mt-4"
                    >
                        @include('courier.form-inputs')

                        <div class="mt-10">
                            <a href="{{ route('courier.index') }}" class="button">
                                <i
                                    class="
                                        mr-1
                                        icon
                                        ion-md-return-left
                                        text-primary
                                    "
                                ></i>
                                @lang('crud.common.back')
                            </a>

                            <a href="{{ route('courier.create') }}" class="button">
                                <i class="mr-1 icon ion-md-add text-primary"></i>
                                @lang('crud.common.create')
                            </a>

                            <button
                                type="submit"
                                class="button float-right"
                                style="background-color: #132a3f; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#3a4c5e'; this.style.color='white';" onmouseout="this.style.backgroundColor='#132a3f'; this.style.color='white';"
                            >
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.update')
                            </button>
                        </div>
                    </x-form>
                </x-partials.card>
            </div>
        </div>
    </div>
</x-app-layout>
