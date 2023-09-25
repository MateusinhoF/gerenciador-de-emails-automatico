<?php

namespace App\Console\Commands;

use App\Mail\EnviarEmail;
use App\Models\ParaEnviar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class EnviarEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para efetuar o envio dos emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $paraenviar = DB::table('para_enviar')->where('continuar_envio','=',true)->get();

        foreach ($paraenviar as $enviar) {

            if(isset($enviar->data_inicio)){
                $hoje = Carbon::today();

                if($hoje->greaterThanOrEqualTo($enviar->data_inicio) && $hoje->lessThanOrEqualTo($enviar->data_fim)){
                    $this->enviar($enviar);
                }else{
                    DB::table('para_enviar')
                        ->where('id','=',$enviar->id)
                        ->update(['continuar_envio'=>false]);
                }
            }

            if(!isset($enviar->data_inicio)){
                $this->enviar($enviar);
            }
        }
    }

    private function enviar($enviar){

        $emails = $this->buscarListaEmails($enviar->titulo_lista_de_emails_id);
        $emailscc = $this->buscarListaEmails($enviar->titulo_lista_de_emails_cc_id);
        $emailscco = $this->buscarListaEmails($enviar->titulo_lista_de_emails_cco_id);

        $corpoemail = DB::table('corpo_email')->where('id','=',$enviar->corpo_email_id)->get();
        $corpoemail = $corpoemail->get(0);
        $nomes = DB::table('nomes')->where('id','=',$enviar->nomes_id)->get();
        $nomes = $nomes->get(0);

        $corpoemail->texto = Str::replace('@nome1',$nomes->nome1??'',$corpoemail->texto);
        $corpoemail->texto = Str::replace('@nome2',$nomes->nome2??'',$corpoemail->texto);
        $corpoemail->texto = Str::replace('@nome3',$nomes->nome3??'',$corpoemail->texto);
        $corpoemail->texto = Str::replace('@nome4',$nomes->nome4??'',$corpoemail->texto);
        $corpoemail->texto = Str::replace('@nome5',$nomes->nome5??'',$corpoemail->texto);

        Mail::to($emails)
            ->cc($emailscc)
            ->bcc($emailscco)
            ->send(new EnviarEmail([
                'assunto'=>$corpoemail->assunto,
                'corpo'=>$corpoemail->texto
            ]));

    }

    private function buscarListaEmails($titulo_lista_de_emails_id){
        return DB::table('emails')
            ->join('lista_de_emails','lista_de_emails.emails_id','=','emails.id')
            ->where('lista_de_emails.titulo_lista_de_emails_id','=',$titulo_lista_de_emails_id)
            ->select('emails.email')
            ->get();
    }
}
