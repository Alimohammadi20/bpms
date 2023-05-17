<?php

namespace App\Services\BPMS2\Objects;

use App\Services\BPMS2\interfaces\InputSettingsBuilderInterface;
use Illuminate\Support\Facades\Cache;

class TableInputSettings implements InputSettingsBuilderInterface
{
    protected InputSettings $inputSettings;
    private mixed $input;
    private string $id;

    public function __construct($input, $id)
    {
        $this->id = $id;
        $input->value = json_decode($input->value);
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
        $this->inputSettings->type = 'table';
        $this->inputSettings->rowAddable = $this->input->value->Config->RowAddable;
        $this->inputSettings->rowRemovable = $this->input->value->Config->RowRemovable;
        $this->inputSettings->rowEditable = $this->input->value->Config->RowEditable;
        $this->inputSettings->returnType = $this->input->value->Config->ReturnType;
        $this->inputSettings->minRow = $this->input->value->Config->MinRow;
        $this->inputSettings->maxRow = $this->input->value->Config->MaxRow;
    }

    public function setRegex()
    {
        $this->inputSettings->regex = $this->input->expression ? 'regex=' . $this->input->expression->Regex : '';
    }

    public function setRequired()
    {
        $this->inputSettings->required = ($this->input->required) ? 'required' : '';
    }

    public function setWritable()
    {
        $this->inputSettings->writableProperty['table'][$this->id][$this->id] = $this->input->writable;
        $this->inputSettings->writable = (!$this->input->writable) ? 'readonly="readonly"' : '';
    }

    public function setPlaceholder()
    {
        $this->inputSettings->placeholder = '';
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
        if ($this->input->value) {
            foreach ($this->input->value->Columns as $key => $property) {
                $id = 'table[' . $this->id . '][@index][' . $key . ']';
                $formProperty = $director->build(new InputSettingsBase($property, $id, $key,$this->input));

                if (isset($formProperty->validator)) {
                    $validatorId = 'table[' . $this->id . '][*][' . $key . ']';
                    $this->inputSettings->validator['rules'][$validatorId] = $formProperty->validator['rules'][$id];
                    $this->inputSettings->validator['attributes'][$validatorId] = $formProperty->validator['attributes'][$id];
                }
                if ($formProperty->writableProperty[$id]) {
                    $this->inputSettings->writableProperty['table'][$this->id][] = $key;
                }
                $collect->push($formProperty);
            }
            $this->inputSettings->value = $this->input->value->Data;
        }

        $this->inputSettings->formProperties = $collect;
    }

    public function getResult()
    {
        return $this->inputSettings;
    }

    public function setLaravelValidation()
    {
        // TODO: Implement setLaravelValidation() method.
    }

    public function setReadable()
    {
        $this->inputSettings->readable = $this->input->readable;
    }
}
