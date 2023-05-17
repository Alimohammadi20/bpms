<?php

namespace App\Services\BPMS2\Objects;

class InputSettings
{
    public string $id;
    public mixed $name;
    public string $label;
    public string $type;
    public string $regex;
    public string $required;
    public string $writable;
    public array $writableProperty = [];
    public string $readable;
    public string $writableValueBoolean;
    public string $placeholder;
    public string $hidden;
    public string $disabled;
    public string $component;
    public mixed $value=null;
    public string $hasError;
    //just for File
    public string $fileName;
    public $downloadable = null;
    public $hasFile = null;
    public bool $isVideo;
    public string $defaultValue;
    //just for Enum
    public mixed $values;
    public string $enumSelect;
    //
    public mixed $formProperties;
    public mixed $validator;
}
