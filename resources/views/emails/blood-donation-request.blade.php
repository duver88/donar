<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Donación de Sangre</title>
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
            background-color: #dc3545; 
            color: white; 
            padding: 20px; 
            text-align: center; 
        }
        .content { 
            padding: 30px; 
        }
        .urgent { 
            background-color: #ff6b6b; 
            color: white; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 15px 0; 
            text-align: center;
            font-weight: bold;
        }
        .patient-info { 
            background-color: #f8f9fa; 
            padding: 20px; 
            border-radius: 5px; 
            margin: 15px 0; 
            border-left: 4px solid #007bff;
        }
        .button { 
            display: inline-block; 
            padding: 12px 24px; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 10px 5px; 
            font-weight: bold;
            text-align: center;
        }
        .button-accept { background-color: #28a745; }
        .button-decline { background-color: #6c757d; }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 3px;
            border-left: 3px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🆘 Solicitud Urgente de Donación</h1>
            <p style="margin: 0; font-size: 18px;">Un perrito necesita la ayuda de {{ $pet->name }}</p>
        </div>
        
        <div class="content">
            <p><strong>Hola {{ $pet->tutor->name }},</strong></p>
            
            <p>Te contactamos porque <strong>{{ $pet->name }}</strong> está registrado como donante en nuestro banco de sangre canina, y actualmente tenemos una solicitud urgente que necesita su ayuda.</p>
            
            @if($bloodRequest->urgency_level === 'critica')
            <div class="urgent">
                ⚠️ URGENCIA CRÍTICA - Esta solicitud requiere atención inmediata
            </div>
            @elseif($bloodRequest->urgency_level === 'alta')
            <div class="highlight">
                <strong>⏰ URGENCIA ALTA</strong> - Se necesita respuesta en las próximas 24-48 horas
            </div>
            @endif
            
            <div class="patient-info">
                <h3 style="color: #007bff; margin-top: 0;">📋 Detalles del Paciente que necesita ayuda:</h3>
                <ul style="list-style: none; padding: 0;">
                    <li><strong>🐕 Nombre:</strong> {{ $bloodRequest->patient_name }}</li>
                    <li><strong>🔹 Raza:</strong> {{ $bloodRequest->patient_breed }}</li>
                    <li><strong>⚖️ Peso:</strong> {{ $bloodRequest->patient_weight }} kg</li>
                    <li><strong>🩸 Tipo de sangre:</strong> {{ $bloodRequest->blood_type_needed }}</li>
                    <li><strong>🚨 Urgencia:</strong> {{ ucfirst($bloodRequest->urgency_level) }}</li>
                    <li><strong>📅 Fecha límite:</strong> {{ $bloodRequest->needed_by_date->format('d/m/Y H:i') }}</li>
                </ul>
                
                <h4 style="color: #dc3545;">🏥 Razón Médica:</h4>
                <p style="background-color: white; padding: 10px; border-radius: 3px;">{{ $bloodRequest->medical_reason }}</p>
                
                <h4 style="color: #28a745;">📞 Información de Contacto:</h4>
                <p><strong>Clínica:</strong> {{ $bloodRequest->clinic_contact }}</p>
                <p><strong>Veterinario:</strong> Dr. {{ $bloodRequest->veterinarian->name }}</p>
                <p><strong>Email:</strong> {{ $bloodRequest->veterinarian->email }}</p>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #dc3545;">¿Puede {{ $pet->name }} ayudar a salvar esta vida?</h3>
                
                <p>Por favor responde a esta solicitud:</p>
                
                <a href="mailto:{{ $bloodRequest->veterinarian->email }}?subject=INTERESADO - Donación para {{ $bloodRequest->patient_name }} - {{ $pet->name }}&body=Hola Dr. {{ $bloodRequest->veterinarian->name }},%0D%0A%0D%0AEstoy INTERESADO en que {{ $pet->name }} done sangre para {{ $bloodRequest->patient_name }}.%0D%0A%0D%0AInformación de mi mascota:%0D%0A- Nombre: {{ $pet->name }}%0D%0A- Peso: {{ $pet->weight_kg }}kg%0D%0A- Última donación: {{ $pet->has_donated_before ? 'Sí ha donado antes' : 'Primera vez' }}%0D%0A%0D%0APor favor contáctame para coordinar:%0D%0ATeléfono: {{ $pet->tutor->phone }}%0D%0AEmail: {{ $pet->tutor->email }}%0D%0A%0D%0AEstoy disponible y {{ $pet->name }} está en buen estado de salud.%0D%0A%0D%0ASaludos,%0D%0A{{ $pet->tutor->name }}" 
                   class="button button-accept">
                    ✅ SÍ, ESTOY INTERESADO
                </a>
                
                <a href="mailto:{{ $bloodRequest->veterinarian->email }}?subject=NO DISPONIBLE - Donación para {{ $bloodRequest->patient_name }} - {{ $pet->name }}&body=Hola Dr. {{ $bloodRequest->veterinarian->name }},%0D%0A%0D%0ALamentablemente {{ $pet->name }} NO está disponible para donar en este momento.%0D%0A%0D%0AMotivo: [Por favor especifica: mascota enferma, vacaciones, donó recientemente, etc.]%0D%0A%0D%0AEspero poder ayudar en una próxima ocasión.%0D%0A%0D%0ASaludos,%0D%0A{{ $pet->tutor->name }}" 
                   class="button button-decline">
                    ❌ NO PUEDO AYUDAR
                </a>
            </div>
            
            <div class="highlight">
                <strong>⏱️ Tiempo es vida:</strong> Por favor responde lo antes posible. Cada minuto cuenta para este paciente que necesita ayuda urgente.
            </div>
            
            <hr>
            
            <h4>ℹ️ ¿Qué debo hacer si estoy interesado?</h4>
            <ol>
                <li>Haz clic en "SÍ, ESTOY INTERESADO" arriba</li>
                <li>El veterinario se pondrá en contacto contigo inmediatamente</li>
                <li>Lleva a {{ $pet->name }} a la clínica en el horario acordado</li>
                <li>El proceso es seguro y supervisado por profesionales</li>
                <li>Recibirás un certificado de donación</li>
            </ol>
            
            <p><strong>Gracias por ser parte de nuestra red de héroes de cuatro patas. 🐾❤️</strong></p>
        </div>
        
        <div class="footer">
            <p style="margin: 0; color: #6c757d;">
                <strong>Banco de Sangre Canina - Bucaramanga</strong><br>
                Salvando vidas peludas juntos<br>
                <em>Este email fue enviado porque {{ $pet->name }} está registrado como donante</em>
            </p>
        </div>
    </div>
</body>
</html>