<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/06
 */
use Kahlan\Filter\Filters;
use Kahlan\Reporter\Coverage;
use Kahlan\Reporter\Coverage\Driver\Xdebug;

LaravelKahlan4\Config::bootstrap($this);

$commandLine = $this->commandLine();
$commandLine->option('coverage', 'default', 4);

Filters::apply($this, 'coverage', function ($next) {
    if (!extension_loaded('xdebug')) {
        return;
    }

    $reporters = $this->reporters();
    $coverage = new Coverage([
        'verbosity' => $this->commandLine()->get('coverage'),
        'driver'    => new Xdebug(),
        'path'      => $this->commandLine()->get('src'),
        'exclude'   => [
            '*/Console/*',
            '*/Exceptions/*',
            '*/Middleware/*',
            '*/Requests/*',
            '*/Config/*',
            '*/Routes/*',
            '*/spec/*',
            // '*/Library/*',
        ],
        'colors'    => !$this->commandLine()->get('no-colors')
    ]);
    $reporters->add('coverage', $coverage);
});
