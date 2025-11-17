<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configura tu Contraseña</title>
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
            background-color: #43883D;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #43883D;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
        .clinic-info {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
        }
        .code-box {
            background-color: #f8f9fa;
            border: 2px dashed #6c757d;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
            font-family: monospace;
            font-size: 14px;
            color: #495057;
            word-break: break-all;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Configura tu Contraseña</h1>
            <p style="margin: 0; font-size: 18px; opacity: 0.9;">
                Banco de Sangre Canina - Bucaramanga
            </p>
        </div>

        <div class="content">
            <p><strong>Estimado Dr. {{ $veterinarian->name }},</strong></p>

            <div class="alert-box">
                <h3 style="color: #856404; margin: 0 0 10px 0;">
                    🎉 ¡Tu cuenta ha sido creada exitosamente!
                </h3>
                <p style="margin: 0; color: #856404;">
                    Configura tu contraseña para acceder al sistema
                </p>
            </div>

            <p>
                El administrador ha creado tu cuenta de veterinario en el sistema del
                <strong>Banco de Sangre Canina de Bucaramanga</strong>. Para completar tu registro
                y poder acceder, necesitas crear tu contraseña personal.
            </p>

            <div class="clinic-info">
                <h4 style="margin-top: 0; color: #43883D;">📋 Datos de tu cuenta:</h4>
                <ul style="margin: 0;">
                    <li><strong>Email:</strong> {{ $veterinarian->email }}</li>
                    <li><strong>Nombre:</strong> {{ $veterinarian->name }}</li>
                    <li><strong>Clínica:</strong> {{ $veterinarian->veterinarian->clinic_name }}</li>
                    <li><strong>Ciudad:</strong> {{ $veterinarian->veterinarian->city }}</li>
                    @if($veterinarian->veterinarian->specialty)
                        <li><strong>Especialidad:</strong> {{ $veterinarian->veterinarian->specialty }}</li>
                    @endif
                </ul>
            </div>

            <h4>🔑 Configura tu contraseña ahora:</h4>
            <p>
                Haz clic en el botón de abajo para crear tu contraseña segura. Este enlace
                es válido por <strong>60 minutos</strong>.
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $resetUrl }}" class="button">
                    🔐 CREAR MI CONTRASEÑA
                </a>
            </div>

            <div class="info-box">
                <h4 style="color: #004085; margin-top: 0;">💡 Si el botón no funciona:</h4>
                <p style="color: #004085; margin: 5px 0;">
                    Copia y pega el siguiente enlace en tu navegador:
                </p>
                <div class="code-box">
                    {{ $resetUrl }}
                </div>
            </div>

            <div class="warning-box">
                <h4 style="color: #856404; margin-top: 0;">⚠️ Seguridad:</h4>
                <ul style="color: #856404; margin: 5px 0;">
                    <li>Este enlace expira en 60 minutos</li>
                    <li>Solo puede usarse una vez</li>
                    <li>Si no solicitaste esta cuenta, ignora este email</li>
                    <li>Nunca compartas tu contraseña con nadie</li>
                </ul>
            </div>

            <h4>🚀 Después de configurar tu contraseña:</h4>
            <ol>
                <li><strong>Iniciar sesión:</strong> Accede con tu email y nueva contraseña</li>
                <li><strong>Explorar el dashboard:</strong> Conoce todas las funcionalidades disponibles</li>
                <li><strong>Crear solicitudes:</strong> Solicita donaciones de sangre para tus pacientes</li>
                <li><strong>Gestionar casos:</strong> Realiza seguimiento de tus solicitudes</li>
            </ol>

            <h4>📞 ¿Necesitas ayuda?</h4>
            <p>
                Si tienes problemas configurando tu contraseña o preguntas sobre tu cuenta,
                contáctanos:
            </p>
            <ul>
                <li><strong>Email de soporte:</strong> banco.sangre@bucaramanga.gov.co</li>
                <li><strong>Horario de atención:</strong> Lunes a Viernes, 8:00 AM - 5:00 PM</li>
            </ul>

            <p style="margin-top: 30px;">
                <strong>¡Bienvenido a nuestra red de veterinarios! 🐾❤️</strong>
            </p>

            <p>
                Cordialmente,<br>
                <strong>Equipo del Banco de Sangre Canina</strong><br>
                <em>Alcaldía de Bucaramanga</em>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0; color: #6c757d;">
                <strong>Banco de Sangre Canina - Bucaramanga</strong><br>
                Salvando vidas peludas juntos<br>
                <em>Este es un email automático, por favor no respondas a este mensaje</em>
            </p>
        </div>
    </div>
</body>
</html>
