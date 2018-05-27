<?php

namespace InetStudio\Polls\Http\Requests\Back\Polls;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Polls\Contracts\Http\Requests\Back\Polls\SavePollRequestContract;

/**
 * Class SavePollRequest.
 */
class SavePollRequest extends FormRequest implements SavePollRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [

        ];
    }
}
