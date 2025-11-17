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
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #0369a1 100%);
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
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Banco de Sangre Canina - Alcaldía de Bucaramanga</p>
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
                
                <h4 style="color: #059669;">📞 Información de Contacto:</h4>
                <div style="background-color: #eff6ff; padding: 15px; border-radius: 5px; border-left: 3px solid #1e3a8a;">
                    <p><strong>🏛️ Institución:</strong> Alcaldía de Bucaramanga - Bienestar Animal</p>
                    <p><strong>🏥 Clínica:</strong> {{ $bloodRequest->veterinarian->clinic_name ?? 'Clínica veterinaria' }}</p>
                    <p><strong>👨‍⚕️ Veterinario:</strong> Dr. {{ $bloodRequest->veterinarian->user->name ?? 'No especificado' }}</p>
                    <p><strong>📧 Contacto oficial:</strong> binestaranimal@bucaramanga.gov.co</p>
                </div>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #dc3545;">¿Puede {{ $pet->name }} ayudar a salvar esta vida?</h3>
                
                <p>Por favor responde a esta solicitud:</p>
                
                <a href="mailto:binestaranimal@bucaramanga.gov.co?subject=INTERESADO - Donación para {{ $bloodRequest->patient_name }} - {{ $pet->name }}&body=Estimado equipo de Bienestar Animal,%0D%0A%0D%0AEstoy INTERESADO en que {{ $pet->name }} done sangre para el caso urgente de {{ $bloodRequest->patient_name }}.%0D%0A%0D%0A--- INFORMACIÓN DE MI MASCOTA ----%0D%0A• Nombre: {{ $pet->name }}%0D%0A• Peso: {{ $pet->weight_kg }}kg%0D%0A• Tipo de sangre: {{ $pet->blood_type ?? 'Por determinar' }}%0D%0A• Experiencia previa: {{ $pet->has_donated_before ? 'Sí ha donado antes' : 'Primera vez donando' }}%0D%0A• Estado de salud: Excelente%0D%0A%0D%0A--- MIS DATOS DE CONTACTO ----%0D%0A• Tutor: {{ $pet->tutor->name ?? $pet->user->name }}%0D%0A• Teléfono: {{ $pet->tutor->phone ?? $pet->user->phone }}%0D%0A• Email: {{ $pet->tutor->email ?? $pet->user->email }}%0D%0A%0D%0A--- DISPONIBILIDAD ----%0D%0A{{ $pet->name }} está disponible y en excelente estado de salud. Pueden contactarme en cualquier momento para coordinar la donación.%0D%0A%0D%0AQuedo atento a sus instrucciones.%0D%0A%0D%0ASaludos cordiales,%0D%0A{{ $pet->tutor->name ?? $pet->user->name }}"
                   class="button button-accept">
                    ✅ SÍ, ESTOY INTERESADO
                </a>

                <a href="mailto:binestaranimal@bucaramanga.gov.co?subject=NO DISPONIBLE - Donación para {{ $bloodRequest->patient_name }} - {{ $pet->name }}&body=Estimado equipo de Bienestar Animal,%0D%0A%0D%0ALamentablemente {{ $pet->name }} NO está disponible para donar en este momento para el caso de {{ $bloodRequest->patient_name }}.%0D%0A%0D%0A--- MOTIVO ----%0D%0A[Por favor especifica uno:]%0D%0A□ {{ $pet->name }} está enfermo temporalmente%0D%0A□ Donó recientemente (menos de 3 meses)%0D%0A□ Estamos de vacaciones/viaje%0D%0A□ Tratamiento médico en curso%0D%0A□ Otro motivo: __________________%0D%0A%0D%0A--- MIS DATOS ----%0D%0A• Tutor: {{ $pet->tutor->name ?? $pet->user->name }}%0D%0A• Email: {{ $pet->tutor->email ?? $pet->user->email }}%0D%0A%0D%0AEspero poder ayudar en una próxima ocasión.%0D%0A%0D%0ASaludos,%0D%0A{{ $pet->tutor->name ?? $pet->user->name }}"
                   class="button button-decline">
                    ❌ NO PUEDO AYUDAR AHORA
                </a>
            </div>
            
            <div class="highlight">
                <strong>⏱️ Tiempo es vida:</strong> Por favor responde lo antes posible. Cada minuto cuenta para este paciente que necesita ayuda urgente.
            </div>
            
            <hr>
            
            <h4>ℹ️ ¿Qué debo hacer si estoy interesado?</h4>
            <ol>
                <li><strong>Responde:</strong> Haz clic en "SÍ, ESTOY INTERESADO" arriba</li>
                <li><strong>Coordinación:</strong> El equipo de Bienestar Animal te contactará inmediatamente para coordinar</li>
                <li><strong>Cita:</strong> Te indicarán fecha, hora y lugar específico</li>
                <li><strong>Donación:</strong> Lleva a {{ $pet->name }} en el horario acordado</li>
                <li><strong>Proceso:</strong> Donación segura supervisada por veterinarios calificados</li>
                <li><strong>Certificado:</strong> Recibirás certificación oficial de la Alcaldía</li>
            </ol>

            <div style="background-color: #f0f9ff; padding: 15px; border-radius: 5px; border-left: 3px solid #0369a1; margin: 15px 0;">
                <p style="margin: 0;"><strong>🏛️ Proceso Oficial:</strong> La Alcaldía de Bucaramanga coordina todas las donaciones a través del equipo de Bienestar Animal para garantizar la seguridad y calidad del proceso.</p>
            </div>
            
            <p><strong>Gracias por ser parte de nuestra red de héroes de cuatro patas. 🐾❤️</strong></p>
        </div>
        
        <div class="footer">
            <p style="margin: 0; color: #6c757d;">
                <strong>Banco de Sangre Canina</strong><br>
                <strong style="color: #1e3a8a;">Alcaldía de Bucaramanga - Bienestar Animal</strong><br>
                Salvando vidas peludas juntos<br>
                <em>Este email fue enviado porque {{ $pet->name }} está registrado como donante</em><br>
                <small>📧 Contacto oficial: binestaranimal@bucaramanga.gov.co</small>
            </p>
        </div>
    </div>
</body>
</html>