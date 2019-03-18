<?php

namespace InetStudio\PollsPackage\Polls\Contracts\Http\Requests\Back;

use Illuminate\Http\Request;

/**
 * Interface SaveItemRequestContract.
 */
interface SaveItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool;

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array;

    /**
     * Правила проверки запроса.
     *
     * @param Request $request
     *
     * @return array
     */
    public function rules(Request $request): array;
}
