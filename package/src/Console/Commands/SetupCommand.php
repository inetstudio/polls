<?php

namespace InetStudio\PollsPackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:polls:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup polls package';

    /**
     * Инициализация команд.
     *
     * @return void
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'inetstudio:polls:polls:setup',
            ],
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'inetstudio:polls:options:setup',
            ],
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'inetstudio:polls:votes:setup',
            ],
        ];
    }
}
