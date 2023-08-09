<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ucfirst($product->name) }}
        </h2>
    </x-slot>

    <section class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-4xl lg:py-16">
            <form action="/product/{{$product->id}}" method=POST>
                @csrf
                @method('PATCH')

                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <x-form-input :name="'name'" :type="'text'" :label="'Product name'" :obj="$product" />
                    </div>
                    <div class="w-full">
                        <x-form-input :name="'price'" :type="'number'" :label="'Price'" :obj="$product"/>
                    </div>
                    <div class="sm:col-span-2">
                        <x-form-textarea :name="'description'" :label="'body'" :obj="$product"/>
                    </div>
                </div>
                <x-button>
                    {{ __('Update product') }}
                </x-button>
                <a href="/product/" class='bg-gray-300 hover:bg-gray-400  p-1.5 rounded text-black'>Cancel</a>
                
            </form>
        </div>
    </section>


</x-app-layout>