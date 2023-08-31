<?php

namespace App\Policies;

use App\Models\Chamada;
use App\Models\User;
use App\Models\DataChamada;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Carbon;

class ChamadaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Chamada $chamada)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Chamada $chamada)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Chamada $chamada)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Chamada $chamada)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Chamada $chamada)
    {
        //
    }

    /**
     * Determina se o usuário pode enviar os documentos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chamada  $chamada
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function dataEnvio(User $user, Chamada $chamada)
    {
        $data_envio = $chamada->datasChamada()->where('tipo', DataChamada::TIPO_ENUM['envio'])->first();
        $data_reenvio = $chamada->datasChamada()->where('tipo', DataChamada::TIPO_ENUM['reenvio'])->first();

        if ($data_envio) {
            return $this->checarPeriodo($data_envio);
        }else if($data_reenvio) {
            return $this->checarPeriodo($data_reenvio);
        }
        return false;
    }

    public function periodoRetificacao(User $user, Chamada $chamada)
    {
        $data_reenvio = $chamada->datasChamada()->where('tipo', DataChamada::TIPO_ENUM['reenvio'])->first();
        return $this->checarPeriodo($data_reenvio);
    }

    public function periodoEnvio(User $user, Chamada $chamada)
    {
        $data_envio = $chamada->datasChamada()->where('tipo', DataChamada::TIPO_ENUM['envio'])->first();
        if ($data_envio){
            return $this->checarPeriodo($data_envio);
        }
        return false;
    }

    private function checarPeriodo(DataChamada $data)
    {
        $dataInicio = new Carbon($data->data_inicio);
        $dataFim = new Carbon($data->data_fim);
        $dataHoje = Carbon::now();

        return $dataHoje->between($dataInicio, $dataFim);
    }
}
