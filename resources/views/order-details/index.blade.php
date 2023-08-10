<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order details') }}
        </h2>
    </x-slot>

    @if(!$order)
        no active order found
    @else

    <table class="min-w-full leading-normal">
        <tr>
            <td class=" bg-white text-xs">
                Status: {{ $orderStatus[$order->status] ?? ''}}
            </td>
            <td class=" bg-white text-xs">
                Quantity: {{ $order->total_quantity }}
            </td>
            <td class=" bg-white text-xs ">
                Total Amount: <span class="text-red-900 font-bold text-2xl">{{ number_format($order->total_amount,2)
                    }}</span>
            </td>
            <td class='flex justify-end'>
                @if($order->status == 1 && $order->orderDetail->count())
                <form action="/order/checkout/{{$order->id}}" method=POST>
                    @csrf
                    @method('PATCH')
                    <button class='bg-green-500 rounded p-2 hover:bg-green-600 text-white general-confirm '>Checkout</button>
                </form>
                @endif
                <a href="/order" class='ml-2 bg-gray-300 hover:bg-gray-400  p-2 rounded text-black'>Back</a>
            </td>
        </tr>
    </table>


    <table class="w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Product
                </th>
                <th
                    class="px-2 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Price
                </th>
                <th
                    class="px-2 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Qty
                </th>
                <th
                    class="px-2 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Amount
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetail as $details)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm w-6/12">
                    <div class="flex items-center">
                        
                        {{-- TODO add product image --}}
                        {{-- <div class="flex-shrink-0 w-10 h-10"> --}}
                            {{-- <img class='rounded ' src="https://i.pravatar.cc/50?u={{$details->product->id}} "
                                alt="Random Image"> --}}
                        {{-- </div> --}}
                        <div class="ml-3">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{$details->product->name}}
                            </p>
                            <p class='text-xs text-gray-500'>
                                {{$details->product->description}}
                            </p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                    {{$details->product->price}}
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                    {{$details->quantity}}
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                    {{ number_format($details->quantity * $details->product->price,2) }}
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-xs">
                    <div class="flex text-xs">

                        <form action="/order_detail/remove/{{$details->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type='submit' class='general-confirm pl-1 pr-1 text-gray-500'> remove </button>
                        </form>

                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    
    @endif

</x-app-layout>