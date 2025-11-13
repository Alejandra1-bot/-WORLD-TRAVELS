<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - WORLD TRAVELS en Boyacá</title>
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
            .max-w-md { max-width: 28rem; }
            .mx-auto { margin-left: auto; margin-right: auto; }
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
            .text-blue-600 { color: #2563eb; }
            .mt-4 { margin-top: 1rem; }
        </style>
    @endif
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow max-w-md w-full">
            <h2 class="text-2xl font-bold text-center mb-6">Registrarse</h2>
            <form id="register-form">
                <div class="mb-4">
                    <label for="name" class="block mb-2">Nombre</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="apellido" class="block mb-2">Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="telefono" class="block mb-2">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="nacionalidad" class="block mb-2">Nacionalidad</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block mb-2">Rol</label>
                    <select id="role" name="role" class="w-full px-3 py-2 border rounded-md" required>
                        <option value="Turista">Turista</option>
                        <option value="Guía Turístico">Guía Turístico</option>
                    </select>
                </div>
                <div class="mb-4" id="verification-code-section" style="display: none;">
                    <label for="verification_code" class="block mb-2">Código de Verificación</label>
                    <input type="text" id="verification_code" name="verification_code" class="w-full px-3 py-2 border rounded-md" placeholder="Ingresa el código de 6 caracteres" maxlength="6">
                    <button type="button" id="send-code-btn" class="mt-2 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Enviar Código</button>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Registrarse</button>
            </form>
            <p class="text-center mt-4">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600">Inicia Sesión</a></p>
            <div id="message" class="mt-4 text-center"></div>
        </div>
    </div>

    <script>
        // Mostrar/ocultar campo de código de verificación basado en el rol seleccionado
        document.getElementById('role').addEventListener('change', function() {
            const role = this.value;
            const verificationSection = document.getElementById('verification-code-section');
            if (role === 'Guía Turístico') {
                verificationSection.style.display = 'block';
            } else {
                verificationSection.style.display = 'none';
            }
        });

        // Enviar código de verificación
        document.getElementById('send-code-btn').addEventListener('click', function() {
            const email = document.getElementById('email').value;
            if (!email) {
                document.getElementById('message').innerText = 'Por favor ingresa tu correo electrónico primero';
                return;
            }

            fetch('http://127.0.0.1:8000/api/enviar-codigo-verificacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ Email: email }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').innerText = 'Código de verificación enviado a tu correo electrónico';
                } else {
                    document.getElementById('message').innerText = 'Error al enviar el código de verificación';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al enviar el código de verificación');
                document.getElementById('message').innerText = 'Error al enviar el código de verificación';
            });
        });

        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const apellido = document.getElementById('apellido').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;
            const telefono = document.getElementById('telefono').value;
            const nacionalidad = document.getElementById('nacionalidad').value;
            const role = document.getElementById('role').value;
            const verification_code = document.getElementById('verification_code').value;

            if (password !== password_confirmation) {
                alert('Las contraseñas no coinciden');
                document.getElementById('message').innerText = 'Las contraseñas no coinciden';
                return;
            }

            const requestData = {
                Nombre: name,
                Apellido: apellido,
                Email: email,
                Contraseña: password,
                Telefono: telefono,
                Nacionalidad: nacionalidad,
                Rol: role
            };

            if (role === 'Guía Turístico') {
                requestData.codigo_verificacion = verification_code;
            }

            fetch('http://127.0.0.1:8000/api/registrar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(requestData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    let errorMessage = 'Error en el registro';
                    if (data.message) {
                        errorMessage = data.message;
                    } else if (data.errors) {
                        // Mostrar errores de validación
                        const errors = Object.values(data.errors).flat();
                        errorMessage = errors.join('\n');
                    }
                    alert(errorMessage);
                    document.getElementById('message').innerText = errorMessage;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al registrarse. Revisa la consola para más detalles.');
                document.getElementById('message').innerText = 'Error al registrarse';
            });
        });
    </script>
</body>
</html>