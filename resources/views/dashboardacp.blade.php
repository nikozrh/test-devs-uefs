<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<style>
    .box {
        cursor: pointer;
    }
</style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Styles login -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="{{ asset('uploads/logo.png') }}" width="195">
                    <!-- Cadastro -->                   
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="w-full py-6">
                    <div class="flex">
                        <div class="w-1/3">
                            <div class="relative mb-2">
                                <div class="w-10 h-10 mx-auto bg-green-700 rounded-full text-lg text-white flex items-center">
                                    <span class="text-center text-white w-full">
                                        <i class="fa fa-cloud" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs text-center md:text-base">Dados</div>
                        </div>

                        <div class="w-1/3">
                            <div class="relative mb-2">
                                <div class="absolute flex align-center items-center align-middle content-center" style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                                        <div class="w-0 bg-green-700 py-1 rounded" style="width: 50%;" id="bar-step-1"></div>
                                    </div>
                                </div>

                                <div class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center" id="icon-step-2">
                                    <span class="text-center text-gray-600 w-full">
                                        <i class="fa fa-tint" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs text-center md:text-base">Nuvem</div>
                        </div>

                        <div class="w-1/3">
                            <div class="relative mb-2">
                                <div class="absolute flex align-center items-center align-middle content-center" style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                    <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                                        <div class="w-0 bg-green-700 py-1 rounded" style="width: 50%;" id="bar-step-2"></div>
                                    </div>
                                </div>

                                <div class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center" id="icon-step-3">
                                    <span class="text-center text-gray-600 w-full">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs text-center md:text-base">Download</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('getdata') }}" id="form-register">
                    @csrf
                    <div id="passo1">
                        <!-- Tipo de cadastro -->
                        <div class="flex items-center mt-4">
                           
                        </div>
                        <div class="flex items-center mt-4">
                            
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4 mb-4" id="btn-proximo" onclick="return validacampos()">
                                Buscar
                            </button>
                        </div>
                    </div>                   
                </form>
            </div>
        </div>
    </div>
    <style>
        .sm\:max-w-md {
            max-width: 50rem;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"> </script>
</body>

</html>