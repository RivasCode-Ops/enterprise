<?php

declare(strict_types=1);

use App\Models\Broker;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$b = Broker::query()->first();
if ($b === null) {
    fwrite(STDERR, "No broker\n");
    exit(1);
}

$n = $b->properties()->count();
echo $n . PHP_EOL;
exit($n > 0 ? 0 : 2);
