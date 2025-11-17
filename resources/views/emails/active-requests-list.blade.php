<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Casos Activos - Banco de Sangre Canina</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        
        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 25px; border-radius: 10px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">🩸 Casos que necesitan tu ayuda</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px;">
                Hay <strong>{{ $activeRequests->count() }}</strong> casos activos que necesitan donación tipo <strong>{{ $pet->blood_type }}</strong>
            </p>
        </div>

        {{-- Información de la mascota --}}
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #495057; margin: 0 0 10px 0;">🐕 {{ $pet->name }} está registrado como donante</h3>
            <p style="margin: 0; color: #6c757d;">
                Tipo de sangre: <strong>{{ $pet->blood_type }}</strong> | 
                Ciudad: <strong>{{ $pet->tutor->city ?? 'No especificada' }}</strong>
            </p>
        </div>

        @if($activeRequests->count() <= 5)
            {{-- Mostrar solicitudes en el email (máximo 5) --}}
            <div style="margin: 20px 0;">
                <h2 style="color: #495057; font-size: 18px; margin-bottom: 15px;">📋 Casos activos:</h2>
                
                @foreach($activeRequests as $request)
                    <div style="background: white; border: 1px solid #ddd; border-left: 4px solid {{ $request->urgency_level === 'alta' ? '#e74c3c' : ($request->urgency_level === 'media' ? '#f39c12' : '#27ae60') }}; padding: 20px; margin: 15px 0; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        
                        {{-- Cabecera del caso --}}
                        <div style="margin-bottom: 15px;">
                            <h3 style="margin: 0; color: #2c3e50; font-size: 18px;">{{ $request->patient_name }}</h3>
                            <span style="background: {{ $request->urgency_level === 'alta' ? '#e74c3c' : ($request->urgency_level === 'media' ? '#f39c12' : '#27ae60') }}; color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                                {{ $request->urgency_level }}
                            </span>
                        </div>
                        
                        {{-- Información del veterinario --}}
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                            <p style="margin: 0; font-size: 14px;">
                                <strong>👨‍⚕️ Veterinario:</strong> {{ $request->veterinarian->name ?? $request->veterinarian->user->name ?? 'No especificado' }}<br>
                                <strong>🏥 Clínica:</strong> {{ $request->veterinarian->clinic_name }}<br>
                                <strong>📍 Dirección:</strong> {{ $request->veterinarian->clinic_address }}
                            </p>
                        </div>
                        
                        {{-- Descripción del caso --}}
                        <div style="margin-bottom: 15px;">
                            <p style="margin: 0; color: #495057;">
                                <strong>📝 Descripción:</strong><br>
                                {{ $request->description }}
                            </p>
                        </div>
                        
                        {{-- Información adicional --}}
                        <div style="background: #e9ecef; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                            <p style="margin: 0;">
                                <strong>🩸 Tipo de sangre:</strong> {{ $request->blood_type }} | 
                                <strong>📅 Solicitado:</strong> {{ $request->created_at->diffForHumans() }}
                            </p>
                        </div>
                        
                        {{-- Botones de acción --}}
                        <div style="text-align: center; margin-top: 20px;">
                            <a href="{{ route('pets.create') }}"
                               style="background: #27ae60; color: white; padding: 12px 25px; text-decoration: none; border-radius: 25px; margin-right: 15px; font-weight: bold; display: inline-block;">
                                ✅ Registrar mi mascota para ayudar
                            </a>
                            <p style="margin: 10px 0 0 0; font-size: 12px; color: #6c757d;">
                                Si ya tienes mascota registrada como donante,
                                <a href="{{ route('pets.active-requests', $pet->id) }}" style="color: #3498db;">
                                    haz clic aquí para responder directamente
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            
        @else
            {{-- Redirigir a página web cuando hay muchas solicitudes --}}
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 25px; border-radius: 8px; margin: 20px 0; text-align: center;">
                <h2 style="color: #d68910; margin: 0 0 15px 0;">📋 Muchos casos necesitan tu ayuda</h2>
                <p style="margin: 0 0 20px 0; font-size: 16px;">
                    Hay <strong>{{ $activeRequests->count() }}</strong> casos activos. Para una mejor experiencia, 
                    puedes verlos todos en nuestra página web:
                </p>
                
                <a href="{{ route('pets.active-requests', $pet->id) }}" 
                   style="background: #3498db; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 16px; display: inline-block; margin-bottom: 15px;">
                    🌐 Ver todos los casos activos
                </a>
                
                <p style="margin: 15px 0 0 0; font-size: 14px; color: #6c757d;">
                    También puedes responder directamente desde la página web
                </p>
            </div>
            
            {{-- Mostrar solo los 3 más urgentes como preview --}}
            <div style="margin: 20px 0;">
                <h3 style="color: #495057; margin-bottom: 15px;">🚨 Los 3 casos más urgentes:</h3>
                
                @foreach($activeRequests->take(3) as $request)
                    <div style="background: white; border: 1px solid #ddd; border-left: 4px solid #e74c3c; padding: 15px; margin: 10px 0; border-radius: 5px;">
                        <h4 style="margin: 0 0 5px 0; color: #2c3e50;">{{ $request->patient_name }}</h4>
                        <p style="margin: 0; font-size: 14px; color: #6c757d;">
                            {{ Str::limit($request->description, 100) }}
                        </p>
                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #e74c3c; font-weight: bold;">
                            Urgencia: {{ strtoupper($request->urgency_level) }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Información adicional --}}
        <div style="background: #e8f5e8; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; margin: 30px 0;">
            <h3 style="color: #155724; margin: 0 0 10px 0;">ℹ️ ¿Cómo responder?</h3>
            <ul style="margin: 0; padding-left: 20px; color: #155724;">
                <li>Haz clic en "Quiero ayudar" si puedes donar</li>
                <li>Haz clic en "No puedo ahora" si no estás disponible</li>
                <li>El veterinario se pondrá en contacto contigo directamente</li>
                <li>Tu información se compartirá solo si aceptas ayudar</li>
            </ul>
        </div>

        {{-- Footer --}}
        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; border-top: 3px solid #e74c3c;">
            <p style="margin: 0 0 10px 0; color: #495057;">
                <strong>Cada donación puede salvar una vida 🐕❤️</strong>
            </p>
            <p style="margin: 0; font-size: 14px; color: #6c757d;">
                Gracias por ser parte del Banco de Sangre Canina<br>
                <strong>Equipo Dognar</strong>
            </p>
        </div>
        
    </div>
</body>
</html>