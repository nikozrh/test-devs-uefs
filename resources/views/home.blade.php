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
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="{{ asset('uploads/logo.png') }}" width="195">                    
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="w-full py-6">
                    <div class="flex">
                        <div class="w-1/3">

                        </div>

                        <div class="w-1/3">
                            <div class="relative mb-2">
                                <div class="w-10 h-10 mx-auto bg-white border-2 border-gray-200 rounded-full text-lg text-white flex items-center" id="icon-step-2">
                                    <span class="text-center text-gray-600 w-full">
                                        <i class="fas fa-cloud"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs text-center md:text-base">Somente AUTORIZADO(s)</div>
                        </div>

                        <div class="w-1/3">

                        </div>
                    </div>
                </div>
                @if ($errors->any())
                <div class="mb-4 text-red-600" style="margin: 4% 30%;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('login') }}" id="form-login">
                    @csrf
                    <div>
                        <label for="loginsge" class="labelFormLogin">Login</label>
                        <input class="inputFormLogin" type="text" name="email" id="loginsge" required>
                        <label for="senhasge" class="labelFormLogin">Senha</label>
                        <input class="inputFormLogin" type="password" name="password" id="senhasge" required>
                        <span id="errocredenciais">Credenciais inválidas!</span>                        
                        <button type="submit" id="sumbitsge" class="animated-button">
                            <span>Acessar</span>
                            <span></span>
                        </button>                       
                    </div>
                </form>

                <!-- Link para exibir o formulário de cadastro -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        <a href="javascript:void(0);" id="link_cadastro" class="text-blue-500 hover:text-blue-700" onclick="toggleCadastroForm()">Não possui cadastro? Clique!</a>
                    </p>
                </div>

                <!-- Formulário de Cadastro de Novo Usuário (Inicialmente oculto) -->
                <div id="form-cadastro" class="hidden mt-4">
                    <h2 class="text-center text-lg font-bold mb-4">Cadastrar Novo Usuário</h2>
                    <form method="POST" action="{{ route('register') }}" id="form-register">
                        @csrf
                        <div>
                            <label for="name" class="labelFormLogin">Nome Completo</label>
                            <input class="inputFormLogin" type="text" name="name" id="name" required>

                            <label for="email" class="labelFormLogin">Email</label>
                            <input class="inputFormLogin" type="email" name="email" id="email" required>

                            <label for="password" class="labelFormLogin">Senha</label>
                            <input class="inputFormLogin" type="password" name="password" id="password" required>

                            <label for="password_confirmation" class="labelFormLogin">Confirmar Senha</label>
                            <input class="inputFormLogin" type="password" name="password_confirmation" id="password_confirmation" required>

                            <button type="submit" id="submit-cadastro" class="animated-button">Cadastrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script>
        function toggleCadastroForm() {

            var cadastroForm = document.getElementById("form-cadastro");
            var linknew = document.getElementById("link_cadastro");

            // Alterna a visibilidade do formulário (mostra ou esconde)
            cadastroForm.classList.toggle("hidden");
            linknew.classList.toggle("hidden");
        }
    </script>


    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"> </script>
</body>

</html>