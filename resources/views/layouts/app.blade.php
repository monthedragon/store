<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.1/dist/cdn.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="bg-white rounded-md w-full">
                                    <div class=" items-center justify-between">
                                        {{ $slot }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </main>
        </div>
    </body>
    <x-flash />
        
    {{-- Will be integrated to all possible processes --}}
    <x-ajax-flash />
    <script>
        $(document).ready(function() {
            $('.pagination p:first-child').remove();

            $('.ajax-form').submit(function() {
                event.preventDefault();
                var action = $(this).prop('action');
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.flash){
                            $('#ajax-flash-msg').html(response.flash);
                            $('#div-ajax-flash-msg').show();
                            
                            setTimeout(function() {
                                $('#div-ajax-flash-msg').hide(); // Hide the container after 3 seconds
                            }, 3000);
                        }else{
                            alert('Done');
                        }
                    },
                    error: function(xhr, status, error) {
                        // console.log(error);
                        alert('Request failed, please try again later.')
                    }
                });
            });

            $('.delete-confirm').click(function(){
                if(!confirm('Proceed with the deletion?')){
                    event.preventDefault();
                }
                return true;
            })
            
            $('.general-confirm').click(function(){
                if(!confirm('Proceed with process?')){
                    event.preventDefault();
                }
                return true;
            })
        });
    </script>
</html>
