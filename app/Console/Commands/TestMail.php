<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo de prueba para verificar la configuración';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Enviando correo de prueba...');
        $this->info('Destinatario: ' . $email);
        $this->info('Remitente configurado: ' . config('mail.from.address'));
        
        try {
            Mail::raw(
                'Este es un correo de prueba desde Dognar - Banco de Sangre Canina de Bucaramanga.' . "\n\n" .
                'Si recibes este mensaje, la configuración de correo está funcionando correctamente.' . "\n\n" .
                'Enviado desde: ' . config('mail.from.address') . "\n" .
                'Fecha: ' . now()->format('Y-m-d H:i:s'),
                function ($message) use ($email) {
                    $message->to($email)
                            ->subject('🐕 Prueba de Correo - Banco de Sangre Canina');
                }
            );
            
            $this->info('✅ Correo enviado exitosamente a: ' . $email);
            $this->info('Revisa tu bandeja de entrada y spam.');
            
        } catch (\Exception $e) {
            $this->error('❌ Error enviando correo:');
            $this->error($e->getMessage());
            
            // Mostrar configuración actual para debug
            $this->newLine();
            $this->warn('Configuración actual:');
            $this->line('MAIL_MAILER: ' . config('mail.default'));
            $this->line('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
            $this->line('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
            $this->line('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
            $this->line('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
            $this->line('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
            
            return 1;
        }
        
        return 0;
    }
}