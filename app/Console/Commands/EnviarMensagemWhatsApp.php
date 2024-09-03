<?php

namespace App\Console\Commands;

use App\Mail\EnviarEmail;
use App\Models\Anexos;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class EnviarMensagemWhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para enviar mensagem de WhatsApp';

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

        if ($envios != null){

            $mensagem = DB::table('mensagem')->where('id','=',$enviar->mensagem_id)->get();
            $mensagem = $mensagem->get(0);
            $nomes = DB::table('nomes')->where('id','=',$enviar->nomes_id)->get();
            $nomes = $nomes->get(0);

            $mensagem->texto = Str::replace('@nome1',$nomes->nome1??'',$mensagem->texto);
            $mensagem->texto = Str::replace('@nome2',$nomes->nome2??'',$mensagem->texto);
            $mensagem->texto = Str::replace('@nome3',$nomes->nome3??'',$mensagem->texto);
            $mensagem->texto = Str::replace('@nome4',$nomes->nome4??'',$mensagem->texto);
            $mensagem->texto = Str::replace('@nome5',$nomes->nome5??'',$mensagem->texto);

            $this->enviarWhatsApp($envios, $mensagem->texto);
        }
        
    }

    private function buscarListaEnvios($titulo_lista_de_envios_id){
        return DB::table('informacoes_de_envios')
            ->join('lista_de_envios','lista_de_envios.informacoes_de_envios_id','=','informacoes_de_envios.id')
            ->where('lista_de_envios.titulo_lista_de_envios_id','=',$titulo_lista_de_envios_id)
            ->select('informacoes_de_envios.telefone')
            ->get();
    }

    private function enviarWhatsApp($listaNumeros, $texto)
    {
        $twilio = new Client(config('services.twilio.sid'),config('services.twilio.token'));
        $from = config('services.twilio.whatsapp_from');

        foreach ($listaNumeros as $numero){

            $telefone = substr_replace($numero->telefone, '', 2,1);
            $twilio->messages->create('whatsapp:+55'.$telefone,[
                "from"=>'whatsapp:+'.$from,
                "body"=>'Você possui um e-mail favor verificar - '.$texto
            ]);
        }
    }

}
