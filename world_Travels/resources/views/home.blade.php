<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Travels</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-4">Descubre Boyacá</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Explora la riqueza histórica, cultural y natural de Boyacá. Desde pueblos coloniales hasta aventuras en la naturaleza, encuentra tu próximo destino inolvidable.</p>
            <a href="#actividades" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300">Explorar Actividades</a>
        </div>
    </section>


    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">WORLD TRAVELS</h1>
            <nav class="space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">Inicio</a>
                <a href="{{ route('search') }}" class="text-gray-700 hover:text-blue-600 transition">Buscar Actividades</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 transition">Mi Dashboard</a>
                    <a href="{{ route('logout') }}" class="text-gray-700 hover:text-blue-600 transition">Cerrar Sesión</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Registrarse</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <!-- Featured Destinations -->
        <section class="mb-16">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Destinos Destacados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="https://via.placeholder.com/400x250?text=Villa+de+Leyva" alt="Villa de Leyva" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2 text-gray-800">Villa de Leyva</h3>
                        <p class="text-gray-600 mb-4">Pueblo colonial con plazas empedradas, iglesias históricas y paisajes andinos que te transportarán al pasado.</p>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Saber más →</a>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="https://via.placeholder.com/400x250?text=Sogamoso" alt="Sogamoso" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2 text-gray-800">Sogamoso</h3>
                        <p class="text-gray-600 mb-4">Ciudad termal con aguas medicinales y cercanía al Parque Nacional Pisba, ideal para el descanso y la aventura.</p>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Saber más →</a>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="https://via.placeholder.com/400x250?text=Tunja" alt="Tunja" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2 text-gray-800">Tunja</h3>
                        <p class="text-gray-600 mb-4">Capital de Boyacá, con arquitectura colonial y el Museo Casa del Fundador, cuna de la independencia.</p>
                        <a href="#" class="text-blue-600 font-semibold hover:text-blue-800">Saber más →</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Activities Section -->
        <section id="actividades" class="mb-16">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Actividades Turísticas</h2>
            <div id="actividades-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Actividades se cargarán aquí con JavaScript -->
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('search') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition duration-300">Ver Todas las Actividades</a>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="bg-blue-50 rounded-2xl p-12 text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-gray-800">¿Listo para tu aventura en Boyacá?</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Regístrate ahora y accede a ofertas exclusivas, reseñas de viajeros y planificación personalizada de tu viaje.</p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition duration-300">Crear Cuenta</a>
                <a href="{{ route('login') }}" class="border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition duration-300">Iniciar Sesión</a>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">WORLD TRAVELS en Boyacá</h3>
                    <p class="text-gray-400">Descubre la magia de Boyacá, un departamento lleno de historia, cultura y naturaleza que te espera con los brazos abiertos.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Inicio</a></li>
                        <li><a href="{{ route('search') }}" class="text-gray-400 hover:text-white transition">Buscar Actividades</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Síguenos</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2025 Turismo en Boyacá. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const actividadesList = document.getElementById('actividades-list');

            // Mostrar mensaje de carga
            actividadesList.innerHTML = '<p class="col-span-full text-center text-gray-500 text-lg">Cargando actividades...</p>';

            fetch('/api/listarActividades')
                .then(response => response.json())
                .then(data => {
                    actividadesList.innerHTML = ''; // Limpiar mensaje de carga

                    if (data.length === 0) {
                        // Datos de ejemplo si no hay actividades
                        const actividadesEjemplo = [
                            {
                                nombre_actividad: 'Visita al Museo Casa del Fundador',
                                descripcion: 'Explora la historia de Colombia en este museo ubicado en el corazón de Tunja.',
                                precio: 15000,
                                ubicacion: 'Tunja, Boyacá',
                                imagen: 'https://via.placeholder.com/400x250?text=Museo+Casa+del+Fundador'
                            },
                            {
                                nombre_actividad: 'Paseo por Villa de Leyva',
                                descripcion: 'Recorre las calles empedradas y plazas coloniales de este pueblo mágico.',
                                precio: 25000,
                                ubicacion: 'Villa de Leyva, Boyacá',
                                imagen: 'https://via.placeholder.com/400x250?text=Villa+de+Leyva'
                            },
                            {
                                nombre_actividad: 'Baños Termales en Sogamoso',
                                descripcion: 'Relájate en las aguas medicinales de los termales de Sogamoso.',
                                precio: 30000,
                                ubicacion: 'Sogamoso, Boyacá',
                                imagen: 'https://via.placeholder.com/400x250?text=Baños+Termales'
                            }
                        ];

                        actividadesEjemplo.forEach(actividad => {
                            const div = document.createElement('div');
                            div.className = 'bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300';
                            div.innerHTML = `
                                <img src="${actividad.imagen}" alt="${actividad.nombre_actividad}" class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <h3 class="text-2xl font-bold mb-2 text-gray-800">${actividad.nombre_actividad}</h3>
                                    <p class="text-gray-600 mb-4">${actividad.descripcion}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-blue-600">$${actividad.precio}</span>
                                        <span class="text-sm text-gray-500">${actividad.ubicacion}</span>
                                    </div>
                                    <button onclick="window.location.href='{{ route('search') }}'" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">Ver Más</button>
                                </div>
                            `;
                            actividadesList.appendChild(div);
                        });
                        return;
                    }

                    // Mostrar actividades reales
                    data.forEach(actividad => {
                        const div = document.createElement('div');
                        div.className = 'bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300';
                        div.innerHTML = `
                            <img src="${actividad.Imagen || 'https://via.placeholder.com/400x250?text=Actividad'}" alt="${actividad.Nombre_Actividad}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">${actividad.Nombre_Actividad}</h3>
                                <p class="text-gray-600 mb-4">${actividad.Descripcion}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-2xl font-bold text-blue-600">$${actividad.Precio}</span>
                                    <span class="text-sm text-gray-500">${actividad.Ubicacion}</span>
                                </div>
                                <button onclick="window.location.href='{{ route('search') }}'" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">Ver Más</button>
                            </div>
                        `;
                        actividadesList.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error('Error cargando actividades:', error);
                    actividadesList.innerHTML = '<p class="col-span-full text-center text-red-500 text-lg">Error al cargar las actividades. Mostrando actividades de ejemplo...</p>';

                    // Mostrar actividades de ejemplo en caso de error
                    const actividadesEjemplo = [
                        {
                            nombre_actividad: 'Visita al Museo Casa del Fundador',
                            descripcion: 'Explora la historia de Colombia en este museo ubicado en el corazón de Tunja.',
                            precio: 15000,
                            ubicacion: 'Tunja, Boyacá',
                            imagen: 'https://via.placeholder.com/400x250?text=Museo+Casa+del+Fundador'
                        },
                        {
                            nombre_actividad: 'Paseo por Villa de Leyva',
                            descripcion: 'Recorre las calles empedradas y plazas coloniales de este pueblo mágico.',
                            precio: 25000,
                            ubicacion: 'Villa de Leyva, Boyacá',
                            imagen: 'https://via.placeholder.com/400x250?text=Villa+de+Leyva'
                        },
                        {
                            nombre_actividad: 'Baños Termales en Sogamoso',
                            descripcion: 'Relájate en las aguas medicinales de los termales de Sogamoso.',
                            precio: 30000,
                            ubicacion: 'Sogamoso, Boyacá',
                            imagen: 'https://via.placeholder.com/400x250?text=Baños+Termales'
                        }
                    ];

                    setTimeout(() => {
                        actividadesList.innerHTML = '';
                        actividadesEjemplo.forEach(actividad => {
                            const div = document.createElement('div');
                            div.className = 'bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300';
                            div.innerHTML = `
                                <img src="${actividad.imagen}" alt="${actividad.nombre_actividad}" class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <h3 class="text-2xl font-bold mb-2 text-gray-800">${actividad.nombre_actividad}</h3>
                                    <p class="text-gray-600 mb-4">${actividad.descripcion}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-blue-600">$${actividad.precio}</span>
                                        <span class="text-sm text-gray-500">${actividad.ubicacion}</span>
                                    </div>
                                    <button onclick="window.location.href='{{ route('search') }}'" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">Ver Más</button>
                                </div>
                            `;
                            actividadesList.appendChild(div);
                        });
                    }, 1000);
                });
        });
    </script>
</body>
</html>
