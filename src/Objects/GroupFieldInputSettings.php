<?php

namespace App\Services\BPMS2\Objects;

use App\Services\BPMS2\interfaces\InputSettingsBuilderInterface;

class GroupFieldInputSettings implements InputSettingsBuilderInterface
{
    protected InputSettings $inputSettings;
    private mixed $input;
    private string $id;
    private array $writable = [];
    private array $validator = [];

    public function __construct($input, $id)
    {
        $this->id = $id;
        $this->input = $input;
        $this->inputSettings = new InputSettings();
    }

    public function setId()
    {
        $this->inputSettings->id = $this->id;
    }

    public function setName()
    {
        $this->inputSettings->name = $this->input->name;
    }

    public function setLabel()
    {
        $this->inputSettings->label = (($this->input->required) ? ' * ' : '') . $this->input->name;
    }

    public function setType()
    {
        $this->inputSettings->type = 'GroupField';
    }

    public function setRegex()
    {
        $this->inputSettings->regex = $this->input->expression ? 'regex=' . $this->input->Expression->Regex : '';
    }

    public function setRequired()
    {
        $this->inputSettings->required = ($this->input->required) ? 'required' : '';
    }

    public function setWritable()
    {
        $this->inputSettings->writable = $this->input->writable;
        $this->inputSettings->writableProperty = $this->writable;
    }

    public function setPlaceholder()
    {
        $this->inputSettings->placeholder = $this->input->placeholder ?? '';
    }

    public function setHidden()
    {
        $this->inputSettings->hidden = str_contains(strtolower($this->input->id), 'hiden') ? "d-none" : '';
    }

    public function setHasError()
    {
        $this->inputSettings->hasError = '';
    }

    public function setWritableValueBoolean()
    {
        $this->inputSettings->writableValueBoolean = $this->input->writable;
    }

    public function setValue()
    {
        $director = new InputSettingsDirector();
        $collect = collect();
        $inputs = json_decode($this->input->value);
        if ($inputs) {
            foreach ($inputs as $key => $property) {
                $newProperty = $director->build(new InputSettingsBase($property, $key,$key));
                if (isset($newProperty->validator)) {
                    $this->validator = array_merge($this->validator, $newProperty->validator);
                }
                if (isset($newProperty->writableValueBoolean) && $newProperty->writableValueBoolean) {
                    $this->writable['input'][] = $newProperty->id;
                }
                $collect->push($newProperty);
            }
        }
        $this->inputSettings->formProperties = $collect;
    }

    public function getResult()
    {
        return $this->inputSettings;
    }

    public function setLaravelValidation()
    {
        $this->inputSettings->validator = $this->validator;
    }

    public function setReadable()
    {
        $this->inputSettings->readable = $this->input->readable;
    }
}
