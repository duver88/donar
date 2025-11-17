# Instrucciones para Configuración del Servidor

## 🔧 Configuración Necesaria

### 1. Agregar al archivo `.env` en el servidor:

```bash
# Agregar esta línea para configurar encriptación TLS en emails
MAIL_ENCRYPTION=tls
```

### 2. ⚠️ IMPORTANTE: Configuración Actual de Emails

**CAMBIO RECIENTE (2025-11-17):**

Los emails ahora se envían de forma **síncrona** (inmediata) en lugar de usar colas. Esto significa:

- ✅ **Ventaja:** Los emails se envían inmediatamente sin necesidad de queue worker
- ⚠️ **Desventaja:** La creación de veterinarios puede tardar 2-3 segundos más mientras se envía el email

Si prefieres que los emails se envíen en segundo plano (más rápido pero requiere configuración), sigue la sección "Opcional: Configurar Queue Worker" más abajo.

### 3. Opcional: Verificar que el Queue Worker esté corriendo

Si quieres que los emails se envíen en segundo plano (recomendado para producción), necesitas configurar un queue worker:

#### Opción A: Usar Supervisor (Recomendado para producción)

Crear archivo de configuración en el servidor: `/etc/supervisor/conf.d/dognar-worker.conf`

```ini
[program:dognar-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /ruta/completa/al/proyecto/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/ruta/completa/al/proyecto/storage/logs/worker.log
stopwaitsecs=3600
```

Luego ejecutar:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start dognar-worker:*
```

#### Opción B: Cron Job (Alternativa más simple)

Agregar al crontab del servidor:

```bash
* * * * * cd /ruta/completa/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
* * * * * cd /ruta/completa/al/proyecto && php artisan queue:work database --stop-when-empty >> /dev/null 2>&1
```

### 3. Verificar logs

Si los emails no llegan, revisar los logs:

```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Buscar errores específicos de email
grep -i "mail\|password\|veterinarian" storage/logs/laravel.log | tail -20
```

### 4. Verificar tabla de jobs

Los emails en cola se guardan en la tabla `jobs` de la base de datos:

```sql
-- Ver jobs pendientes
SELECT * FROM jobs ORDER BY created_at DESC LIMIT 10;

-- Ver jobs fallidos
SELECT * FROM failed_jobs ORDER BY failed_at DESC LIMIT 10;
```

## 🐛 Solución de Problemas

### Si los emails no llegan:

1. **Verificar credenciales de Outlook:**
   ```bash
   # Probar conexión SMTP
   telnet smtp-mail.outlook.com 587
   ```

2. **Verificar que el queue worker esté corriendo:**
   ```bash
   # Ver procesos
   ps aux | grep "queue:work"

   # Si está con supervisor
   sudo supervisorctl status
   ```

3. **Procesar manualmente la cola (temporal):**
   ```bash
   php artisan queue:work database --once
   ```

4. **Limpiar caché de configuración:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Si la creación es lenta:

⚠️ **NOTA (2025-11-17):** Actualmente usa `Mail::send()` síncrono. Si la creación tarda mucho (más de 5 segundos), considera configurar el queue worker (ver sección 3 arriba) y cambiar a `Mail::queue()`.

## 📊 Monitoreo

### Verificar que todo funcione:

```bash
# Ver jobs procesados recientemente
php artisan queue:failed

# Reintentar jobs fallidos
php artisan queue:retry all

# Ver estado de la cola
php artisan queue:monitor database
```

## 🔐 Seguridad

- Las contraseñas temporales son aleatorias de 6 dígitos
- Los tokens de reset expiran en 60 minutos
- Los tokens solo pueden usarse una vez
- Los emails se envían desde: `binestaranimal@bucaramanga.gov.co`

## 📝 Logs Importantes

Los logs ahora incluyen:
- ✅ Generación de token de reset
- ✅ Email enviado exitosamente
- ✅ Errores con stack trace completo
- ✅ User ID y email para debugging

Ejemplo de log exitoso:
```
[2025-11-17 12:00:00] local.INFO: Generando token de reset para veterinario {"user_id":123,"email":"vet@example.com","token_generated":true}
[2025-11-17 12:00:01] local.INFO: Email de configuración de contraseña enviado exitosamente {"user_id":123,"email":"vet@example.com"}
```
