<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva mascota registrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .pet-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .alert {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🐕 Nueva Mascota Registrada</h1>
        <p>¡{{ $pet->name }} ahora puede donar sangre!</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $tutor->name }}</strong>,</p>

        <p>¡Excelentes noticias! Has registrado exitosamente a <strong>{{ $pet->name }}</strong> como un nuevo donante en nuestro banco de sangre canina.</p>

        <div class="pet-info">
            <h3>Información de {{ $pet->name }}:</h3>
            <ul>
                <li><strong>Nombre:</strong> {{ $pet->name }}</li>
                <li><strong>Raza:</strong> {{ $pet->breed }}</li>
                <li><strong>Especie:</strong> {{ ucfirst($pet->species) }}</li>
                <li><strong>Edad:</strong> {{ $pet->age_years }} años</li>
                <li><strong>Peso:</strong> {{ $pet->weight_kg }} kg</li>
                <li><strong>Tipo de sangre:</strong> {{ $pet->blood_type ?? 'Por determinar' }}</li>
                <li><strong>Estado:</strong> <span style="color: #28a745;">✅ Aprobado como donante</span></li>
            </ul>
        </div>

        <div class="alert">
            <strong>📋 ¿Qué sigue?</strong><br>
            Tu mascota ya está disponible para donar sangre cuando sea necesario. Te contactaremos por email cuando haya una solicitud urgente que coincida con el perfil de {{ $pet->name }}.
        </div>

        <h3>🩸 Importancia de la donación de sangre canina:</h3>
        <p>Gracias a donantes como {{ $pet->name }}, podemos salvar vidas de mascotas en situaciones críticas. Tu compromiso con esta causa hace la diferencia.</p>

        <h3>📞 Información de contacto:</h3>
        <p>Si tienes alguna pregunta o necesitas actualizar la información de {{ $pet->name }}, no dudes en contactarnos.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('home') }}" class="btn">Ver Solicitudes Activas</a>
        </div>

        <p><strong>¡Gracias por ser parte de esta noble causa!</strong></p>
        <p>Tu compromiso ayuda a salvar vidas caninas en momentos críticos.</p>
    </div>

    <div class="footer">
        <p>Este correo fue enviado automáticamente por el Banco de Sangre Canina.</p>
        <p>Si no deseas recibir más correos, puedes contactarnos para ser removido de la lista.</p>
    </div>
</body>
</html>