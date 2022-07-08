<?php

namespace Src\Session;

use Src\Models\Session;
use Src\Models\User;

class AccessControl
{
    /**
     * @var string O id da sessão.
     */
    private string $session_id;

    /**
     * @return bool Inicia uma sessão, se nenhuma outra existir.
     */
    public function startSession(): bool
    {
        $this->session_id = session_create_id();

        return true;
    }

    /**
     * Destrói a sessão e todos os dados que ela contém.
     * @return bool Retorna falso caso não acha sessão ativa.
     */
    public function destroySession(int $session_id): bool
    {
        $sessionModel = new Session();

        return $sessionModel->deleteById($session_id);
    }

    /**
     * Seta um valor de sessão
     * @param $key string|int Chave a ser setada
     * @param $value mixed Valor a ser setado para a chave
     * @return bool Retorna falso se a chave já existir.
     */
    public function set($key, $value): bool
    {
        if (! isset($_SESSION[$key])) {
            $_SESSION[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Retorna um valor da sessão
     * @param $key string|int O dado a ser resgatado da sessão
     * @return mixed|bool Retorna falso caso a chave não tenha sido iniciada na sessão
     */
    public function get($key)
    {
        if (isset($_SESSION[$key])) return $_SESSION[$key];

        return false;
    }

    /**
     * @param int $user_id O id do usuário para o qual a sessão será iniciada
     * @return bool
     */
    public function persistSession(int $user_id): bool
    {
        $sessionModel = new Session();

        try {
            $session = $sessionModel->insert([
                $user_id,
                $this->session_id
            ]);
        } catch (\Throwable $exception) {
            dump([
                'file' => $exception->getFile(),
                'code' => $exception->getCode(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]);
        }

        if (! $session) return false;

        return true;
    }

    /**
     * Apaga determinado dado de uma sessão
     * @param $key string|int Dado a ser apagado
     * @return bool Retorna falso se a chave não existir.
     */
    public function unset($key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return false|string Retorna o id da sessão se esta existir
     */
    public function getSessionId()
    {
        if ($this->exists()) {
            return $this->session_id;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }

        return true;
    }

    /**
     * Atualiza o token de acesso
     * @param int $user_id
     * @return bool
     */
    public function refreshToken(int $user_id)
    {
        $sessionModel = new Session();
        $updatedToken = $sessionModel->updateToken($user_id);

        if (!$updatedToken) {
            return false;
        }

        $this->session_id = $updatedToken;
        return true;
    }
}