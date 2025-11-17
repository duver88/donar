<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Aprobada</title>
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
            background-color: #28a745; 
            color: white; 
            padding: 30px 20px; 
            text-align: center; 
        }
        .content { 
            padding: 30px; 
        }
        .success-badge {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .button { 
            display: inline-block; 
            padding: 15px 30px; 
            background-color: #007bff; 
            color: white; 
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 ¡Bienvenido al Banco de Sangre Canina!</h1>
            <p style="margin: 0; font-size: 18px; opacity: 0.9;">
                Tu cuenta ha sido aprobada exitosamente
            </p>
        </div>
        
        <div class="content">
            <p><strong>Estimado Dr. {{ $veterinarian->name }},</strong></p>
            
            <div class="success-badge">
                <h3 style="color: #155724; margin: 0 0 10px 0;">
                    ✅ Tu cuenta de veterinario ha sido APROBADA
                </h3>
                <p style="margin: 0; color: #155724;">
                    Ya puedes acceder a todas las funcionalidades del sistema
                </p>
            </div>
            
            <p>
                Nos complace informarte que tu solicitud para unirte a nuestra red de veterinarios 
                colaboradores del <strong>Banco de Sangre Canina de Bucaramanga</strong> ha sido 
                <strong>aprobada exitosamente</strong>.
            </p>
            
            <div class="clinic-info">
                <h4 style="margin-top: 0; color: #007bff;">📋 Datos de tu cuenta registrada:</h4>
                <ul style="margin: 0;">
                    <li><strong>Email:</strong> {{ $veterinarian->email }}</li>
                    <li><strong>Tarjeta Profesional:</strong> {{ $veterinarian->veterinarian->professional_card }}</li>
                    <li><strong>Clínica:</strong> {{ $veterinarian->veterinarian->clinic_name }}</li>
                    <li><strong>Ciudad:</strong> {{ $veterinarian->veterinarian->city }}</li>
                    @if($veterinarian->veterinarian->specialty)
                        <li><strong>Especialidad:</strong> {{ $veterinarian->veterinarian->specialty }}</li>
                    @endif
                </ul>
            </div>
            
            <h4>🚀 ¿Qué puedes hacer ahora?</h4>
            <ol>
                <li><strong>Iniciar sesión:</strong> Accede a tu dashboard personalizado de veterinario</li>
                <li><strong>Crear solicitudes:</strong> Solicita donaciones de sangre para tus pacientes en emergencias</li>
                <li><strong>Gestionar casos:</strong> Realiza seguimiento de todas tus solicitudes activas</li>
                <li><strong>Conectar con donantes:</strong> Acceso directo a nuestra red de donantes en Bucaramanga</li>
            </ol>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ config('app.url') }}/login" class="button">
                    🔐 INICIAR SESIÓN AHORA
                </a>
            </div>
            
            <div class="info-box">
                <h4 style="color: #004085; margin-top: 0;">💡 Primeros pasos recomendados:</h4>
                <ul style="color: #004085; margin: 0;">
                    <li>Explora tu dashboard para familiarizarte con todas las funciones disponibles</li>
                    <li>Revisa los donantes activos disponibles en tu ciudad</li>
                    <li>Guarda nuestros datos de contacto para casos de emergencia</li>
                    <li>Revisa el manual de usuario para optimizar el uso del sistema</li>
                </ul>
            </div>
            
            <h4>📞 ¿Necesitas ayuda?</h4>
            <p>
                Si tienes alguna pregunta sobre el uso del sistema o necesitas asistencia técnica, 
                no dudes en contactarnos:
            </p>
            <ul>
                <li><strong>Email de soporte:</strong> banco.sangre@bucaramanga.gov.co</li>
                <li><strong>Horario de atención:</strong> Lunes a Viernes, 8:00 AM - 5:00 PM</li>
            </ul>
            
            <p>
                Estamos aquí para apoyarte en esta importante misión de 
                <strong>salvar vidas peludas en Bucaramanga</strong>.
            </p>
            
            <p style="margin-top: 30px;">
                <strong>¡Gracias por unirte a nuestra red de héroes veterinarios! 🐾❤️</strong>
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
                <em>Tu cuenta está activa y lista para usar</em>
            </p>
        </div>
    </div>
</body>
</html>