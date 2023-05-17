<?php

namespace App\Services\BPMS2\interfaces;

use Illuminate\Support\Collection;

interface ProcessBaseInterface
{
    function execute(): Collection;

}
