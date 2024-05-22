<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class EnviarMensagemSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para enviar SMS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            $paraenviar = DB::table('para_enviar')->where('continuar_envio', '=', true)->where('user_id','=', $user->id)->get();

            foreach ($paraenviar as $enviar) {

                if (isset($enviar->data_inicio)) {
                    $hoje = Carbon::today();

                    if ($hoje->greaterThanOrEqualTo($enviar->data_inicio) && $hoje->lessThanOrEqualTo($enviar->data_fim)) {
                        $this->enviar($enviar, $user);
                    } else {
                        DB::table('para_enviar')
                            ->where('id', '=', $enviar->id)
                            ->update(['continuar_envio' => false]);
                    }
                }

                if (!isset($enviar->data_inicio)) {
                    $this->enviar($enviar, $user);
                }
            }
        }
    }

    private function enviar($enviar, $user){

        $envios = $this->buscarListaEnvios($enviar->titulo_lista_de_envios_id);
//        $envioscc = $this->buscarListaEnvios($enviar->titulo_lista_de_envios_cc_id);
//        $envioscco = $this->buscarListaEnvios($enviar->titulo_lista_de_envios_cco_id);

        $this->enviarSMS($envios);

    }

    private function buscarListaEnvios($titulo_lista_de_envios_id){
        return DB::table('envios')
            ->join('lista_de_envios','lista_de_envios.envios_id','=','envios.id')
            ->where('lista_de_envios.titulo_lista_de_envios_id','=',$titulo_lista_de_envios_id)
            ->select('envios.telefone')
            ->get();
    }

    private function enviarSMS($listaNumeros)
    {
        $twilio = new Client(config('services.twilio.sid'),config('services.twilio.token'));
        $from = config('services.twilio.numero_telefone');

        foreach ($listaNumeros as $numero){
            $twilio->messages->create('+55'.$numero->telefone,[
                "from"=>'+'.$from,
                "body"=>'Você possui um e-mail da UTFPR, favor verificar.'
            ]);
        }
    }

}
