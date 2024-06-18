<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorez</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans md:font-serif">
    <nav class="bg-gray-400 border-gray-200 dark:bg-gray-900 text-white fixed inset-x-0 top-0 z-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Motorez</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>

            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-400 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-gray-400 dark:bg-gray-400 md:dark:bg-gray-400 dark:border-gray-700">
                    <li>
                        <a href="{{ route('home') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-400 md:hover:bg-gray-400 md:border-0 md:hover:text-white md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-400 dark:hover:text-white md:dark:hover:bg-gray-400">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('vehicles.index') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-400 md:hover:bg-gray-400 md:border-0 md:hover:text-white md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-400 dark:hover:text-white md:dark:hover:bg-gray-400">Veiculos</a>
                    </li>
                    <li>
                        <a href="{{ route('vehicles.create') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-400 md:hover:bg-gray-400 md:border-0 md:hover:text-white md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-400 dark:hover:text-white md:dark:hover:bg-gray-400">Novo
                            Veiculo</a>
                    </li>
                    <li>
                        <a href="{{ route('webmotors') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-400 md:hover:bg-gray-400 md:border-0 md:hover:text-white md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-400 dark:hover:text-white md:dark:hover:bg-gray-400">Carros
                            WebMotors</a>
                    </li>
                    <li>
                        <a href="{{ route('revendaMais') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-400 md:hover:bg-gray-400 md:border-0 md:hover:text-white md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-400 dark:hover:text-white md:dark:hover:bg-gray-400">Carros
                            Revenda Mais</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="border-b border-gray-200 my-4"></div>
    <div style="margin-top: 60px;">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>