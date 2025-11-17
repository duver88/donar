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
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #0369a1 100%);
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
            border-left: 4px solid #1e3a8a;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: bold;
        }
        .alert {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #1e3a8a;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #059669;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #059669;
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
        <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Banco de Sangre Canina - Alcaldía de Bucaramanga</p>
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

        <div class="alert-success">
            <strong>📋 ¿Qué sigue?</strong><br>
            {{ $pet->name }} ya está disponible para donar sangre cuando sea necesario. Te contactaremos por email cuando haya una solicitud urgente que coincida con su perfil.
        </div>

        <div class="alert">
            <strong>🏛️ Proceso Oficial de Donación:</strong><br>
            • Cuando haya una solicitud urgente, recibirás un email con los detalles<br>
            • Si estás interesado, responderás a <strong>binestaranimal@bucaramanga.gov.co</strong><br>
            • El equipo de Bienestar Animal coordinará la fecha, hora y lugar<br>
            • La donación se realizará bajo supervisión veterinaria profesional<br>
            • Recibirás certificación oficial de la Alcaldía de Bucaramanga
        </div>

        <h3>🩸 Importancia de la donación de sangre canina:</h3>
        <p>Gracias a donantes como {{ $pet->name }}, podemos salvar vidas de mascotas en situaciones críticas. Tu compromiso con esta causa hace la diferencia.</p>

        <h3>📞 Información de contacto:</h3>
        <p>Si tienes alguna pregunta o necesitas actualizar la información de {{ $pet->name }}, contáctanos:</p>
        <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 15px; border-radius: 5px; text-align: center; margin: 15px 0;">
            <p style="margin: 0; font-weight: bold;">📧 binestaranimal@bucaramanga.gov.co</p>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Equipo de Bienestar Animal - Alcaldía de Bucaramanga</p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('home') }}" class="btn">Ver Solicitudes Activas</a>
        </div>

        <p><strong>¡Gracias por ser parte de esta noble causa!</strong></p>
        <p>Tu compromiso ayuda a salvar vidas caninas en momentos críticos.</p>
    </div>

    <div class="footer">
        <p><strong>Banco de Sangre Canina</strong></p>
        <p><strong style="color: #1e3a8a;">Alcaldía de Bucaramanga - Bienestar Animal</strong></p>
        <p>Este correo fue enviado automáticamente porque registraste a {{ $pet->name }} como donante.</p>
        <p><small>📧 Contacto: binestaranimal@bucaramanga.gov.co</small></p>
    </div>
</body>
</html>