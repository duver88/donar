<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Donante Registrado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .donor-info {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #1e3a8a;
        }
        .alert-info {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e3a8a;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #1e3a8a;
        }
        .contact-box {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .highlight {
            background-color: #fef3cd;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #fbbf24;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐕 Nuevo Donante Registrado</h1>
            <p style="margin: 0; font-size: 16px;">{{ $pet->name }} se ha unido a nuestra red de donantes</p>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Banco de Sangre Canina - Alcaldía de Bucaramanga</p>
        </div>

        <div class="content">
            <p><strong>Estimado Dr. {{ $veterinarian->user->name }},</strong></p>

            <p>Te informamos que tenemos un <strong>nuevo donante disponible</strong> en nuestro banco de sangre canina que podría ser compatible con futuras solicitudes de tu clínica.</p>

            <div class="donor-info">
                <h3 style="color: #059669; margin-top: 0;">📋 Información del Nuevo Donante:</h3>
                <ul style="list-style: none; padding: 0;">
                    <li><strong>🐕 Nombre:</strong> {{ $pet->name }}</li>
                    <li><strong>🔹 Raza:</strong> {{ $pet->breed }}</li>
                    <li><strong>🏷️ Especie:</strong> {{ ucfirst($pet->species) }}</li>
                    <li><strong>⚖️ Peso:</strong> {{ $pet->weight_kg }} kg</li>
                    <li><strong>🎂 Edad:</strong> {{ $pet->age_years }} años</li>
                    <li><strong>🩸 Tipo de sangre:</strong> {{ $pet->blood_type ?? 'Por determinar en primera donación' }}</li>
                    <li><strong>📍 Ciudad:</strong> {{ $pet->tutor->city ?? ($pet->user->city ?? 'Bucaramanga') }}</li>
                    <li><strong>✅ Estado:</strong> <span style="color: #059669;">Aprobado y disponible</span></li>
                </ul>
            </div>

            <div class="highlight">
                <strong>🏥 Para Veterinarios:</strong> Este donante está disponible para casos urgentes que requieran transfusión de sangre. {{ $pet->name }} cumple con todos los requisitos de salud y edad para ser donante.
            </div>

            <div class="contact-box">
                <h3 style="margin-top: 0;">📧 Proceso de Solicitud</h3>
                <p style="margin: 10px 0;">Para solicitar una donación de {{ $pet->name }} o cualquier otro donante disponible:</p>
                <p style="font-size: 18px; font-weight: bold; margin: 15px 0;">
                    📧 binestaranimal@bucaramanga.gov.co
                </p>
                <p style="font-size: 14px; opacity: 0.9;">
                    El equipo de Bienestar Animal coordinará el contacto con el tutor
                </p>
            </div>

            <div class="alert-info">
                <h4 style="margin-top: 0; color: #1e3a8a;">ℹ️ Información Importante:</h4>
                <ul style="margin-bottom: 0;">
                    <li><strong>Confidencialidad:</strong> Los datos de contacto del tutor son confidenciales</li>
                    <li><strong>Coordinación oficial:</strong> Todas las donaciones se coordinan a través de Bienestar Animal</li>
                    <li><strong>Proceso seguro:</strong> Se verifica el estado de salud antes de cada donación</li>
                    <li><strong>Disponibilidad:</strong> El tutor será consultado sobre disponibilidad para cada caso</li>
                </ul>
            </div>

            <h3 style="color: #059669;">🩸 ¿Cómo solicitar una donación?</h3>
            <ol>
                <li><strong>Identifica la necesidad:</strong> Caso urgente que requiera transfusión</li>
                <li><strong>Contacta oficialmente:</strong> Envía solicitud a binestaranimal@bucaramanga.gov.co</li>
                <li><strong>Proporciona detalles:</strong> Información completa del paciente y urgencia</li>
                <li><strong>Coordinación:</strong> Bienestar Animal contactará donantes compatibles</li>
                <li><strong>Proceso:</strong> Se coordinará fecha, hora y lugar para la donación</li>
            </ol>

            <p><strong>Gracias por ser parte de nuestra red veterinaria que salva vidas. 🐾❤️</strong></p>
        </div>

        <div class="footer">
            <p style="margin: 0; color: #6c757d;">
                <strong>Banco de Sangre Canina</strong><br>
                <strong style="color: #1e3a8a;">Alcaldía de Bucaramanga - Bienestar Animal</strong><br>
                Salvando vidas peludas juntos<br>
                <small>📧 Contacto oficial: binestaranimal@bucaramanga.gov.co</small>
            </p>
        </div>
    </div>
</body>
</html>