<?php

namespace InetStudio\PollsPackage\Polls\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\PollsPackage\Polls\Contracts\Http\Requests\Back\SaveItemRequestContract;

/**
 * Class SaveItemRequest.
 */
class SaveItemRequest extends FormRequest implements SaveItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'question.required' => 'Поле «Вопрос» обязательно для заполнения',
            'question.max' => 'Поле «Вопрос» не должно превышать 255 символов',

            'options.required' => 'Поле «Ответы» обязательно для заполнения',
            'options.array' => 'Поле «Ответы» должно содержать значение в виде массива',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'question' => 'required|max:255',
            'options' => 'required|array',
        ];
    }
}
