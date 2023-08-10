<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Product') }}
        </h2>
    </x-slot>

    <section class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-4xl ">
            <form action="/product/store" method=POST>
                @csrf

                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <x-form-input :name="'name'" :type="'text'" :label="'Product name'" />
                    </div>
                    <div class="w-full">
                        <x-form-input :name="'price'" :type="'number'" :label="'Price'" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-form-textarea :name="'description'" :label="'body'" />
                    </div>
                </div>
                <x-button>
                    {{ __('Add product') }}
                </x-button>
                
            </form>
        </div>
    </section>


</x-app-layout>