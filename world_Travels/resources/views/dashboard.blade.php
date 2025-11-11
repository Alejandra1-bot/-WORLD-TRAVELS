<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - WORLD TRAVELS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">WORLD TRAVELS</h1>
            <nav class="space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">Inicio</a>
                <a href="{{ route('search') }}" class="text-gray-700 hover:text-blue-600 transition">Buscar Actividades</a>
                <a href="{{ route('logout') }}" class="text-gray-700 hover:text-blue-600 transition">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-center mb-4 text-gray-800">Mi Dashboard</h2>
            <p class="text-center text-gray-600">Bienvenido, <span id="user-name" class="font-semibold"></span></p>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12" id="stats-section">
            <!-- Estadísticas se cargarán aquí -->
        </div>

        <!-- Panel de acciones según rol -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12" id="actions-section">
            <!-- Acciones se cargarán aquí -->
        </div>

        <!-- Lista de actividades/reservas -->
        <div class="bg-white rounded-xl shadow-lg p-8" id="list-section">
            <!-- Lista se cargará aquí -->
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            loadUserData();
            loadStats();
            loadActions();
            loadList();
        });

        function loadUserData() {
            fetch('/api/me', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('user-name').textContent = data.usuario.Nombre;
                    localStorage.setItem('user_role', data.usuario.Rol);
                }
            })
            .catch(error => {
                console.error('Error cargando datos del usuario:', error);
                localStorage.removeItem('token');
                window.location.href = '{{ route("login") }}';
            });
        }

        function loadStats() {
            const role = localStorage.getItem('user_role');
            const statsSection = document.getElementById('stats-section');

            if (role === 'Turista') {
                // Estadísticas para turista
                fetch('/api/listarReservas', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const totalReservas = data.length;
                    const reservasConfirmadas = data.filter(r => r.Estado === 'confirmada').length;

                    statsSection.innerHTML = `
                        <div class="bg-blue-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-blue-600">${totalReservas}</h3>
                            <p class="text-gray-600">Total Reservas</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-green-600">${reservasConfirmadas}</h3>
                            <p class="text-gray-600">Reservas Confirmadas</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-yellow-600">${totalReservas - reservasConfirmadas}</h3>
                            <p class="text-gray-600">Reservas Pendientes</p>
                        </div>
                    `;
                });
            } else if (role === 'Guía Turístico') {
                // Estadísticas para guía
                fetch('/api/listarActividades', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const totalActividades = data.length;

                    statsSection.innerHTML = `
                        <div class="bg-blue-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-blue-600">${totalActividades}</h3>
                            <p class="text-gray-600">Actividades Creadas</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-green-600">0</h3>
                            <p class="text-gray-600">Reservas Recibidas</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-yellow-600">4.5</h3>
                            <p class="text-gray-600">Calificación Promedio</p>
                        </div>
                    `;
                });
            } else if (role === 'Administrador') {
                // Estadísticas para administrador
                Promise.all([
                    fetch('/api/listarUsuarios').then(r => r.json()),
                    fetch('/api/listarActividades').then(r => r.json()),
                    fetch('/api/listarReservas').then(r => r.json())
                ])
                .then(([usuarios, actividades, reservas]) => {
                    statsSection.innerHTML = `
                        <div class="bg-blue-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-blue-600">${usuarios.length}</h3>
                            <p class="text-gray-600">Total Usuarios</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-green-600">${actividades.length}</h3>
                            <p class="text-gray-600">Total Actividades</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg text-center">
                            <h3 class="text-2xl font-bold text-yellow-600">${reservas.length}</h3>
                            <p class="text-gray-600">Total Reservas</p>
                        </div>
                    `;
                });
            }
        }

        function loadActions() {
            const role = localStorage.getItem('user_role');
            const actionsSection = document.getElementById('actions-section');

            if (role === 'Turista') {
                actionsSection.innerHTML = `
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Mis Acciones</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('search') }}" class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Buscar Actividades</h4>
                            <p>Explora nuevas aventuras en Boyacá</p>
                        </a>
                        <button onclick="showReservations()" class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Mis Reservas</h4>
                            <p>Gestiona tus reservas activas</p>
                        </button>
                    </div>
                `;
            } else if (role === 'Guía Turístico') {
                actionsSection.innerHTML = `
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Panel de Guía</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <button onclick="createActivity()" class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Crear Actividad</h4>
                            <p>Añade nuevas experiencias turísticas</p>
                        </button>
                        <button onclick="manageActivities()" class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Gestionar Actividades</h4>
                            <p>Edita tus actividades existentes</p>
                        </button>
                        <button onclick="viewReservations()" class="bg-yellow-600 text-white p-6 rounded-lg hover:bg-yellow-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Ver Reservas</h4>
                            <p>Revisa solicitudes de participantes</p>
                        </button>
                    </div>
                `;
            } else if (role === 'Administrador') {
                actionsSection.innerHTML = `
                    <h3 class="text-2xl font-bold mb-6 text-gray-800">Panel Administrativo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <button onclick="manageUsers()" class="bg-blue-600 text-white p-6 rounded-lg hover:bg-blue-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Gestionar Usuarios</h4>
                            <p>Administra cuentas de usuario</p>
                        </button>
                        <button onclick="manageActivities()" class="bg-green-600 text-white p-6 rounded-lg hover:bg-green-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Gestionar Actividades</h4>
                            <p>Supervisa todas las actividades</p>
                        </button>
                        <button onclick="manageCategories()" class="bg-yellow-600 text-white p-6 rounded-lg hover:bg-yellow-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Categorías</h4>
                            <p>Gestiona categorías de actividades</p>
                        </button>
                        <button onclick="viewReports()" class="bg-purple-600 text-white p-6 rounded-lg hover:bg-purple-700 transition text-center">
                            <h4 class="text-xl font-semibold mb-2">Reportes</h4>
                            <p>Visualiza estadísticas del sistema</p>
                        </button>
                    </div>
                `;
            }
        }

        function loadList() {
            const role = localStorage.getItem('user_role');
            const listSection = document.getElementById('list-section');

            if (role === 'Turista') {
                fetch('/api/listarReservas', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let html = '<h3 class="text-2xl font-bold mb-6 text-gray-800">Mis Reservas</h3>';
                    if (data.length === 0) {
                        html += '<p class="text-gray-600">No tienes reservas activas.</p>';
                    } else {
                        html += '<div class="space-y-4">';
                        data.forEach(reserva => {
                            html += `
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold">Reserva #${reserva.id}</h4>
                                    <p>Fecha: ${reserva.Fecha_Reserva}</p>
                                    <p>Personas: ${reserva.Numero_Personas}</p>
                                    <p>Estado: <span class="px-2 py-1 rounded text-sm ${reserva.Estado === 'confirmada' ? 'bg-green-100 text-green-800' : reserva.Estado === 'cancelada' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'}">${reserva.Estado}</span></p>
                                </div>
                            `;
                        });
                        html += '</div>';
                    }
                    listSection.innerHTML = html;
                });
            } else if (role === 'Guía Turístico') {
                fetch('/api/listarActividades', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let html = '<h3 class="text-2xl font-bold mb-6 text-gray-800">Mis Actividades</h3>';
                    if (data.length === 0) {
                        html += '<p class="text-gray-600">No has creado actividades aún.</p>';
                    } else {
                        html += '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';
                        data.forEach(actividad => {
                            html += `
                                <div class="border rounded-lg p-4">
                                    <img src="${actividad.Imagen || 'https://via.placeholder.com/300x200?text=Actividad'}" alt="${actividad.Nombre_Actividad}" class="w-full h-32 object-cover rounded mb-2">
                                    <h4 class="font-semibold">${actividad.Nombre_Actividad}</h4>
                                    <p class="text-sm text-gray-600">${actividad.Descripcion}</p>
                                    <p class="text-sm">Precio: $${actividad.Precio}</p>
                                    <p class="text-sm">Cupo: ${actividad.Cupo_Maximo}</p>
                                </div>
                            `;
                        });
                        html += '</div>';
                    }
                    listSection.innerHTML = html;
                });
            } else if (role === 'Administrador') {
                fetch('/api/listarUsuarios', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let html = '<h3 class="text-2xl font-bold mb-6 text-gray-800">Gestión de Usuarios</h3>';
                    html += '<div class="overflow-x-auto">';
                    html += '<table class="w-full table-auto">';
                    html += '<thead><tr class="bg-gray-100"><th class="px-4 py-2">Nombre</th><th class="px-4 py-2">Email</th><th class="px-4 py-2">Rol</th><th class="px-4 py-2">Acciones</th></tr></thead>';
                    html += '<tbody>';
                    data.forEach(usuario => {
                        html += `
                            <tr class="border-b">
                                <td class="px-4 py-2">${usuario.Nombre} ${usuario.Apellido}</td>
                                <td class="px-4 py-2">${usuario.Email}</td>
                                <td class="px-4 py-2">${usuario.Rol}</td>
                                <td class="px-4 py-2">
                                    <button onclick="editUser(${usuario.id})" class="bg-blue-500 text-white px-2 py-1 rounded text-sm mr-2">Editar</button>
                                    <button onclick="deleteUser(${usuario.id})" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Eliminar</button>
                                </td>
                            </tr>
                        `;
                    });
                    html += '</tbody></table></div>';
                    listSection.innerHTML = html;
                });
            }
        }

        // Funciones de acción (placeholders)
        function createActivity() { alert('Función para crear actividad'); }
        function manageActivities() { alert('Función para gestionar actividades'); }
        function viewReservations() { alert('Función para ver reservas'); }
        function manageUsers() { alert('Función para gestionar usuarios'); }
        function manageCategories() { alert('Función para gestionar categorías'); }
        function viewReports() { alert('Función para ver reportes'); }
        function showReservations() { alert('Función para mostrar reservas'); }
        function editUser(id) { alert('Editar usuario ' + id); }
        function deleteUser(id) { alert('Eliminar usuario ' + id); }
    </script>
</body>
</html>