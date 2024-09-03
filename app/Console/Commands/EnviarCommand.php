<?php

namespace App\Console\Commands;

use App\Mail\EnviarEmail;
use App\Models\Anexos;
use App\Models\ParaEnviar;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class EnviarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para efetuar o envio das notificações';

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
        $envioscc = $this->buscarListaEnvios($enviar->titulo_lista_de_envios_cc_id);
        $envioscco = $this->buscarListaEnvios($enviar->titulo_lista_de_envios_cco_id);

        $mensagem = DB::table('mensagem')->where('id','=',$enviar->mensagem_id)->get();
        $mensagem = $mensagem->get(0);
        $nomes = DB::table('nomes')->where('id','=',$enviar->nomes_id)->get();
        $nomes = $nomes->get(0);

        $mensagem->texto = Str::replace('@nome1',$nomes->nome1??'',$mensagem->texto);
        $mensagem->texto = Str::replace('@nome2',$nomes->nome2??'',$mensagem->texto);
        $mensagem->texto = Str::replace('@nome3',$nomes->nome3??'',$mensagem->texto);
        $mensagem->texto = Str::replace('@nome4',$nomes->nome4??'',$mensagem->texto);
        $mensagem->texto = Str::replace('@nome5',$nomes->nome5??'',$mensagem->texto);

        $listaAnexos = DB::table('lista_anexos')->where('user_id','=',$user->id)->where('vinculador_anexos_id','=',$mensagem->vinculador_anexos_id)->get();
        $anexos = [];

        if ($listaAnexos != null) {
            foreach ($listaAnexos as $anexo) {
                $anexo = Anexos::where('user_id', '=', $user->id)->where('id', '=', $anexo->anexos_id)->first();
                array_push($anexos, $anexo);
            }
        }

        $senha_email = Crypt::decrypt($user->senha_email);

        Config::set('mail.mailers.smtp.driver', 'smtp');
        Config::set('mail.mailers.smtp.host', 'smtp.gmail.com');
        Config::set('mail.mailers.smtp.port', 587);
        Config::set('mail.mailers.smtp.encryption', 'tls');
        Config::set('mail.mailers.smtp.username', $user->email);
        Config::set('mail.mailers.smtp.password', $senha_email);

        Mail::to($envios)
            ->cc($envioscc)
            ->bcc($envioscco)
            ->send(new EnviarEmail([
                'assunto'=>$mensagem->assunto,
                'corpo'=>$mensagem->texto,
                'anexos'=>$anexos,
                'assinatura'=>$user->assinatura,
                'imagem_assinatura'=>$user->imagem_assinatura,
                ]
            ));

    }

    private function buscarListaEnvios($titulo_lista_de_envios_id){
        return DB::table('informacoes_de_envios')
            ->join('lista_de_envios','lista_de_envios.informacoes_de_envios_id','=','informacoes_de_envios.id')
            ->where('lista_de_envios.titulo_lista_de_envios_id','=',$titulo_lista_de_envios_id)
            ->select('informacoes_de_envios.email')
            ->get();
    }
}
