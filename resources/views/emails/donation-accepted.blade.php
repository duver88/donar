{{-- resources/views/emails/donation-accepted.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donación Aceptada - Banco de Sangre Canina</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        
        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white; padding: 25px; border-radius: 10px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">✅ ¡Excelente noticia!</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px;">
                <strong>{{ $pet->name }}</strong> puede donar sangre para <strong>{{ $bloodRequest->patient_name }}</strong>
            </p>
        </div>

        {{-- Información del donante --}}
        <div style="background: #e8f5e8; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h2 style="color: #155724; margin: 0 0 15px 0;">🐕 Información del donante</h2>
            <div style="background: white; padding: 15px; border-radius: 5px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; width: 35%; border-bottom: 1px solid #f1f1f1;">Mascota:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Raza:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->breed }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Edad:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->age }} años</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Peso:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->weight }} kg</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Género:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->gender === 'male' ? 'Macho' : 'Hembra' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold;">Tipo de sangre:</td>
                        <td style="padding: 8px 0;"><strong style="color: #e74c3c; font-size: 16px;">{{ $pet->blood_type }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Información del tutor --}}
        <div style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h2 style="color: #495057; margin: 0 0 15px 0;">👤 Información del tutor</h2>
            <div style="background: white; padding: 15px; border-radius: 5px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; width: 35%; border-bottom: 1px solid #f1f1f1;">Nombre:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Email:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">
                            <a href="mailto:{{ $pet->user->email }}" style="color: #007bff; text-decoration: none; font-weight: bold;">
                                {{ $pet->user->email }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Teléfono:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">
                            @if($pet->user->phone ?? false)
                                <a href="tel:{{ $pet->user->phone }}" style="color: #28a745; text-decoration: none; font-weight: bold;">
                                    {{ $pet->user->phone }}
                                </a>
                            @else
                                <span style="color: #6c757d; font-style: italic;">No registrado</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; border-bottom: 1px solid #f1f1f1;">Ciudad:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #f1f1f1;">{{ $pet->user->city ?? 'No especificada' }}</td>
                    </tr>
                    @if($pet->emergency_contact)
                        <tr>
                            <td style="padding: 8px 0; font-weight: bold;">Contacto emergencia:</td>
                            <td style="padding: 8px 0;">
                                {{ $pet->emergency_contact }}
                                @if($pet->emergency_phone)
                                    <br><a href="tel:{{ $pet->emergency_phone }}" style="color: #dc3545; text-decoration: none;">
                                        {{ $pet->emergency_phone }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Mensaje del tutor (si lo hay) --}}
        @if($donationResponse->message)
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #d68910; margin: 0 0 10px 0;">💬 Mensaje del tutor:</h3>
                <div style="background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #f39c12;">
                    <p style="margin: 0; font-style: italic; color: #856404; font-size: 15px; line-height: 1.5;">
                        "{{ $donationResponse->message }}"
                    </p>
                </div>
            </div>
        @endif

        {{-- Recordatorio del caso --}}
        <div style="background: #f8f9fa; border-left: 4px solid #007bff; padding: 20px; margin: 20px 0;">
            <h3 style="color: #495057; margin: 0 0 15px 0;">📋 Recordatorio del caso</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px 0; font-weight: bold; width: 25%;">Paciente:</td>
                    <td style="padding: 5px 0;">{{ $bloodRequest->patient_name }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: bold;">Urgencia:</td>
                    <td style="padding: 5px 0;">
                        <span style="background: {{ $bloodRequest->urgency_level === 'alta' ? '#e74c3c' : ($bloodRequest->urgency_level === 'media' ? '#f39c12' : '#27ae60') }}; color: white; padding: 2px 8px; border-radius: 10px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                            {{ $bloodRequest->urgency_level }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: bold;">Tipo de sangre:</td>
                    <td style="padding: 5px 0;"><strong>{{ $bloodRequest->blood_type }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: bold;">Descripción:</td>
                    <td style="padding: 5px 0;">{{ $bloodRequest->description }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0; font-weight: bold;">Solicitado:</td>
                    <td style="padding: 5px 0; color: #6c757d;">{{ $bloodRequest->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        {{-- Información de salud de la mascota --}}
        @if($pet->health_status || $pet->medical_notes)
            <div style="background: #e3f2fd; border: 1px solid #bbdefb; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h3 style="color: #1565c0; margin: 0 0 15px 0;">🏥 Información de salud</h3>
                @if($pet->health_status)
                    <div style="margin-bottom: 10px;">
                        <strong>Estado de salud:</strong> {{ $pet->health_status }}
                    </div>
                @endif
                @if($pet->vaccination_status)
                    <div style="margin-bottom: 10px;">
                        <strong>Vacunas:</strong> 
                        <span style="color: #27ae60; font-weight: bold;">✅ Al día</span>
                    </div>
                @endif
                @if($pet->last_donation_date)
                    <div style="margin-bottom: 10px;">
                        <strong>Última donación:</strong> {{ $pet->last_donation_date->format('d/m/Y') }}
                    </div>
                @endif
                @if($pet->medical_notes)
                    <div style="background: white; padding: 10px; border-radius: 5px; margin-top: 10px;">
                        <strong>Notas médicas:</strong><br>
                        {{ $pet->medical_notes }}
                    </div>
                @endif
            </div>
        @endif

        {{-- Próximos pasos --}}
        <div style="background: #d1ecf1; border: 1px solid #bee5eb; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #0c5460; margin: 0 0 15px 0;">📞 Próximos pasos</h3>
            <ol style="margin: 0; padding-left: 20px; color: #0c5460;">
                <li style="margin-bottom: 8px;">
                    <strong>Contacta al tutor</strong> lo antes posible para coordinar la donación
                </li>
                <li style="margin-bottom: 8px;">
                    <strong>Verifica</strong> que la mascota esté en condiciones óptimas para donar
                </li>
                <li style="margin-bottom: 8px;">
                    <strong>Coordina</strong> fecha, hora y lugar para la donación
                </li>
                <li style="margin-bottom: 8px;">
                    <strong>Confirma</strong> los procedimientos de tu clínica para donaciones
                </li>
                <li>
                    <strong>Informa</strong> al tutor sobre los cuidados post-donación
                </li>
            </ol>
        </div>

        {{-- Botones de acción --}}
        <div style="text-align: center; margin: 30px 0;">
            <div style="margin-bottom: 15px;">
                <a href="mailto:{{ $pet->user->email }}?subject=Donación de sangre para {{ $bloodRequest->patient_name }}&body=Hola {{ $pet->user->name }},%0D%0A%0D%0AGracias por aceptar que {{ $pet->name }} done sangre para {{ $bloodRequest->patient_name }}.%0D%0A%0D%0APor favor, contáctame para coordinar la donación.%0D%0A%0D%0ASaludos,%0D%0A{{ $bloodRequest->veterinarian->user->name }}%0D%0A{{ $bloodRequest->veterinarian->clinic_name }}" 
                   style="background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; margin-right: 15px; font-size: 16px;">
                    📧 Enviar Email
                </a>
            </div>
            
            @if($pet->user->phone ?? false)
                <div style="margin-bottom: 15px;">
                    <a href="tel:{{ $pet->user->phone }}" 
                       style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; font-size: 16px;">
                        📞 Llamar ahora
                    </a>
                </div>
            @endif

            @if($pet->emergency_phone)
                <div>
                    <a href="tel:{{ $pet->emergency_phone }}" 
                       style="background: #dc3545; color: white; padding: 12px 25px; text-decoration: none; border-radius: 20px; font-weight: bold; display: inline-block; font-size: 14px;">
                        🚨 Contacto emergencia
                    </a>
                </div>
            @endif
        </div>

        {{-- Información importante --}}
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h4 style="color: #d68910; margin: 0 0 10px 0;">⚠️ Recordatorios importantes</h4>
            <ul style="margin: 0; padding-left: 20px; color: #856404;">
                <li style="margin-bottom: 5px;">Verifica que la mascota esté sana y no haya donado en los últimos 3 meses</li>
                <li style="margin-bottom: 5px;">Confirma la compatibilidad sanguínea antes del procedimiento</li>
                <li style="margin-bottom: 5px;">Realiza exámenes pre-donación según protocolo de tu clínica</li>
                <li style="margin-bottom: 5px;">Mantén informado al tutor sobre todo el proceso</li>
                <li>Registra la donación en el sistema una vez completada</li>
            </ul>
        </div>

        {{-- Footer --}}
        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; border-top: 3px solid #27ae60;">
            <p style="margin: 0 0 10px 0; color: #495057;">
                <strong>Gracias por salvar vidas caninas 🐕❤️</strong>
            </p>
            <p style="margin: 0; font-size: 14px; color: #6c757d;">
                Banco de Sangre Canina - <strong>Equipo Dognar</strong><br>
                Respuesta recibida el {{ $donationResponse->responded_at->format('d/m/Y H:i') }}
            </p>
        </div>
        
    </div>
</body>
</html>