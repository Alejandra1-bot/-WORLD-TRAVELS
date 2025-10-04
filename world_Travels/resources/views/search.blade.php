<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Actividades - WORLD TRAVELS en Boyacá</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body { font-family: 'Instrument Sans', sans-serif; }
            .bg-blue-600 { background-color: #2563eb; }
            .text-white { color: white; }
            .p-4 { padding: 1rem; }
            .mb-4 { margin-bottom: 1rem; }
            .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
            .rounded { border-radius: 0.25rem; }
            .shadow { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
            .bg-white { background-color: white; }
            .p-6 { padding: 1.5rem; }
            .text-center { text-align: center; }
            .text-2xl { font-size: 1.5rem; }
            .font-bold { font-weight: 700; }
            .mb-6 { margin-bottom: 1.5rem; }
            .block { display: block; }
            .w-full { width: 100%; }
            .border { border: 1px solid #d1d5db; }
            .rounded-md { border-radius: 0.375rem; }
            .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
            .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
            .mb-2 { margin-bottom: 0.5rem; }
            .bg-blue-500 { background-color: #3b82f6; }
            .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
            .grid { display: grid; }
            .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .gap-4 { gap: 1rem; }
            .h-48 { height: 12rem; }
            .object-cover { object-fit: cover; }
            .text-xl { font-size: 1.25rem; }
        </style>
    @endif
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">WORLD TRAVELS en Boyacá</h1>
            <nav>
                <a href="{{ route('home') }}" class="mr-4">Inicio</a>
                <a href="{{ route('search') }}" class="mr-4">Buscar Actividades</a>
                @auth
                    <a href="{{ route('logout') }}">Cerrar Sesión</a>
                @else
                    <a href="{{ route('login') }}" class="mr-4">Iniciar Sesión</a>
                    <a href="{{ route('register') }}">Registrarse</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4">
        <section class="mb-8">
            <h2 class="text-3xl font-bold text-center mb-4">Buscar Actividades</h2>
            <form id="search-form" class="bg-white p-6 rounded shadow mb-6">
                <div class="mb-4">
                    <label for="query" class="block mb-2">Buscar por nombre o descripción</label>
                    <input type="text" id="query" name="query" class="w-full px-3 py-2 border rounded-md">
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Buscar</button>
            </form>
            <div id="results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Resultados se mostrarán aquí -->
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadAllActivities();

            document.getElementById('search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const query = document.getElementById('query').value;
                searchActivities(query);
            });
        });

        function loadAllActivities() {
            fetch('/api/listarActividades')
                .then(response => response.json())
                .then(data => displayActivities(data))
                .catch(error => console.error('Error cargando actividades:', error));
        }

        function searchActivities(query) {
            fetch('/api/listarActividades')
                .then(response => response.json())
                .then(data => {
                    const filtered = data.filter(activity =>
                        activity.nombre_actividad.toLowerCase().includes(query.toLowerCase()) ||
                        activity.descripcion.toLowerCase().includes(query.toLowerCase())
                    );
                    displayActivities(filtered);
                })
                .catch(error => console.error('Error buscando actividades:', error));
        }

        function displayActivities(activities) {
            const results = document.getElementById('results');
            results.innerHTML = '';
            activities.forEach(activity => {
                const div = document.createElement('div');
                div.className = 'bg-white rounded shadow p-4';
                div.innerHTML = `
                    <img src="${activity.imagen || 'https://via.placeholder.com/300x200?text=Actividad'}" alt="${activity.nombre_actividad}" class="w-full h-48 object-cover rounded mb-2">
                    <h3 class="text-xl font-bold">${activity.nombre_actividad}</h3>
                    <p>${activity.descripcion}</p>
                    <p class="font-bold">Precio: $${activity.precio}</p>
                    <p>Ubicación: ${activity.ubicacion}</p>
                `;
                results.appendChild(div);
            });
        }
    </script>
</body>
</html>