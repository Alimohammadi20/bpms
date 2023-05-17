<?php

namespace App\Services\BPMS2\interfaces;

use Illuminate\Support\Collection;

interface InputSettingsBuilderInterface
{
    public function setId();
    public function setName();
    public function setLabel();
    public function setType();
    public function setRegex();
    public function setRequired();
    public function setWritable();
    public function setPlaceholder();
    public function setHidden();
    public function setReadable();
    public function setValue();
    public function setHasError();
    public function setWritableValueBoolean();
    public function setLaravelValidation();
    public function getResult();
}
