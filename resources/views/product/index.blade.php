<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div>
        <form method='POST' action='/product' class='sw-form'>
            @csrf
            <x-input type='hidden' name='page' />
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <input type="text" name='name'
                        value="{{ $name }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Name or Description">
                </div>
                <div>
                    <x-button class=''>
                        {{ __('Search') }}
                    </x-button>
                </div>
            </div>

        </form>
    </div>
    <div>
        <div class=" overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Product
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Price
                            </th>
                            <th
                                class="px-2 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">

                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{$product->name}}
                                        </p>

                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{$product->description}}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{$product->price}}
                                </p>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                                <div class="flex text-xs">
                                    @auth
                                        <form class='ajax-form' method=POST action="/add_to_cart/{{ $product->id }}">
                                            @csrf
                                            <button class='w-20 bg-green-200 p-2 rounded-xl hover:bg-green-400'> Add to
                                                cart</button>
                                        </form>
                                    @else
                                        <p class='text-xs italic text-red-700 text-center'>Login to add order</p>
                                    @endauth

                                    @can('isAdmin')
                                    <a class='ml-2 p-2' href="/product/{{$product->id}}">view</a>

                                    <form method=POST action="/product/{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class='p-2 delete-confirm'>delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class='flex pagination'>
        {{ $products->links() }}
    </div>

    <script>
        $(function(){
           $('.pagination a').click(function(event){
              event.preventDefault();
              var page = parseInt($(this).html());
              $("input[name='page']").val(page);
              $('.sw-form').submit();
           })
    
        })
    </script>
</x-app-layout>