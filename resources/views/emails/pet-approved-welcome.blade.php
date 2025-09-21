<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Banco de Sangre Canina</title>
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
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white; 
            padding: 30px 20px; 
            text-align: center; 
        }
        .content { 
            padding: 30px; 
        }
        .welcome-badge {
            background-color: #d4edda;
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .pet-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .urgent-request {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
        }
        .button { 
            display: inline-block; 
            padding: 12px 24px; 
            background-color: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 10px 5px; 
            font-weight: bold;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido al Banco de Sangre Canina!</h1>
            <p style="margin: 0; font-size: 18px; opacity: 0.9;">
                {{ $pet->name }} ya es oficialmente un héroe donante
            </p>
        </div>
        
        <div class="content">
            <p><strong>Estimado {{ $pet->tutor->name }},</strong></p>
            
            <div class="welcome-badge">
                <h3 style="color: #155724; margin: 0 0 10px 0;">
                    🎉 ¡Felicidades! {{ $pet->name }} ha sido aprobado como donante
                </h3>
                <p style="margin: 0; color: #155724;">
                    Tu mascota ya forma parte de nuestra red de héroes de cuatro patas
                </p>
            </div>
            
            <p>
                Nos complace informarte que <strong>{{ $pet->name }}</strong> ha sido 
                aprobado exitosamente como donante en el <strong>Banco de Sangre Canina de Bucaramanga</strong>.
            </p>
            
            <div class="pet-card">
                <h4 style="margin-top: 0; color: #007bff;">📋 Información de {{ $pet->name }}:</h4>
                <ul style="margin: 0;">
                    <li><strong>Nombre:</strong> {{ $pet->name }}</li>
                    <li><strong>Raza:</strong> {{ $pet->breed }}</li>
                    <li><strong>Peso:</strong> {{ $pet->weight_kg }} kg</li>
                    <li><strong>Edad:</strong> {{ $pet->age_years }} {{ $pet->age_years == 1 ? 'año' : 'años' }}</li>
                    <li><strong>Estado:</strong> <span style="color: #28a745;">✓ Aprobado como donante</span></li>
                </ul>
            </div>
            
            <h4>🚀 ¿Qué pasa ahora?</h4>
            <ol>
                <li><strong>Te contactaremos:</strong> Cuando haya solicitudes urgentes de donación</li>
                <li><strong>Tú decides:</strong> Siempre puedes aceptar o declinar según disponibilidad</li>
                <li><strong>Proceso seguro:</strong> Todas las donaciones son supervisadas por veterinarios</li>
                <li><strong>Certificado:</strong> Recibirás un certificado por cada donación realizada</li>
            </ol>
            
            @if($activeRequests->count() > 0)
                <hr style="margin: 30px 0;">
                
                <h4 style="color: #dc3545;">🚨 ¡Solicitudes Urgentes Actuales!</h4>
                <p>Actualmente tenemos algunas solicitudes urgentes. Si {{ $pet->name }} está disponible y en buen estado de salud, podrías ayudar:</p>
                
                @foreach($activeRequests as $request)
                    <div class="urgent-request">
                        <h5 style="margin: 0 0 10px 0; color: #721c24;">
                            📞 {{ $request->patient_name }} - {{ $request->patient_breed }}
                        </h5>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Urgencia:</strong> 
                            <span style="color: {{ $request->urgency_level === 'critica' ? '#dc3545' : '#ffc107' }};">
                                {{ ucfirst($request->urgency_level) }}
                            </span>
                            | <strong>Peso:</strong> {{ $request->patient_weight }} kg
                            | <strong>Fecha límite:</strong> {{ $request->needed_by_date->format('d/m/Y H:i') }}
                        </p>
                        <p style="margin: 0; font-size: 14px;">
                            <strong>Veterinario:</strong> Dr. {{ $request->veterinarian->name }} 
                            ({{ $request->veterinarian->email }})
                        </p>
                    </div>
                @endforeach
                
                <p style="margin-top: 15px;">
                    <strong>💡 Para ayudar:</strong> Responde directamente al email del veterinario 
                    indicando que {{ $pet->name }} está disponible para donar.
                </p>
            @endif
            
            <div style="background-color: #e7f3ff; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff; margin: 20px 0;">
                <h4 style="color: #004085; margin-top: 0;">💡 Consejos importantes:</h4>
                <ul style="color: #004085; margin: 0;">
                    <li>{{ $pet->name }} debe estar en ayuno 12 horas antes de donar</li>
                    <li>Debe estar tranquilo y sin estrés el día de la donación</li>
                    <li>Las donaciones son cada 2-3 meses máximo para seguridad</li>
                    <li>Cualquier duda, contacta al veterinario solicitante</li>
                </ul>
            </div>
            
            <h4>📞 ¿Necesitas ayuda?</h4>
            <p>
                Si tienes preguntas sobre el proceso de donación o necesitas actualizar 
                los datos de {{ $pet->name }}, contáctanos:
            </p>
            <ul>
                <li><strong>Email:</strong> banco.sangre@bucaramanga.gov.co</li>
                <li><strong>Horario:</strong> Lunes a Viernes, 8:00 AM - 5:00 PM</li>
            </ul>
            
            <p style="margin-top: 30px;">
                <strong>¡Gracias por hacer de {{ $pet->name }} un héroe de cuatro patas! 🐾❤️</strong>
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
                <em>{{ $pet->name }} es ahora parte de nuestra familia de héroes</em>
            </p>
        </div>
    </div>
</body>
</html>
