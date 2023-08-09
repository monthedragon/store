<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Order Details' }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-md w-full">
        <div class=" flex items-center justify-between">
            <div class="w-full overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="w-full leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-2 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th
                                    class="px-2 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class='rounded-full '
                                                src="https://i.pravatar.cc/50?u={{$order->user_id}} "
                                                alt="Random Image">
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{$order->user->name}}
                                            </p>
                                            <p class='text-xs text-gray-500'>
                                                {{$order->user->email}}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                                    {{ $orderStatus[$order->status] ?? ''}}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                                    {{ $order->total_quantity }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                                    {{ number_format($order->total_amount,2) }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                                    <div class="flex text-xs">
                                        <a href="/order/{{$order->id}}" class='pl-1 pr-1 text-blue-500'>view</a>
                                        |

                                        <form action="/order/cancel/{{$order->id}}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type='submit' class='general-confirm pl-1 pr-1 text-gray-500'> cancel </button>
                                            <x-form-input type='hidden' name='page' />
                                        </form>
                                        |
                                        <form action="/order/ship/{{$order->id}}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type='submit' class='general-confirm pl-1 pr-1 text-gray-500'> shipped </button>
                                            <x-input type='hidden' name='page' />
                                        </form>
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
        {{ $orders->links() }}
    </div>
</x-app-layout>