<?php

namespace App\Services\BPMS2\Objects;

use App\Services\BPMS2\interfaces\InputSettingsBuilderInterface;

class InputSettingsDirector
{
    public array $validation = [];

    public function build(InputSettingsBuilderInterface $builder)
    {
        $builder->setId();
        $builder->setName();
        $builder->setLabel();
        $builder->setType();
        $builder->setRegex();
        $builder->setRequired();
        $builder->setReadable();
        $builder->setPlaceholder();
        $builder->setHidden();
        $builder->setValue();
        $builder->setHasError();
        $builder->setWritableValueBoolean();
        $builder->setWritable();
        $builder->setLaravelValidation();
        return $builder->getResult();
    }




}
