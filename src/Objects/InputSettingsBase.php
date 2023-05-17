<?php

namespace App\Services\BPMS2\Objects;

use App\Services\BPMS2\interfaces\InputSettingsBuilderInterface;

class InputSettingsBase implements InputSettingsBuilderInterface
{

    protected InputSettings $inputSettings;
    private mixed $input;
    private mixed $parentInput;
    private string $id;
    private $key;

    public function __construct($input, $id, $key, $parentInput = null)
    {
        $this->id = $id;
        $this->input = $input;
        $this->parentInput = $parentInput;
        $this->inputSettings = new InputSettings();
        $this->inputSettings->key = $key;
    }

    public function setId()
    {
        $this->inputSettings->id = $this->id;
    }

    public function setName()
    {
        $this->inputSettings->name = $this->input->Name;
    }

    public function setLabel()
    {
        $this->inputSettings->label = (($this->input->Required) ? ' * ' : '') . $this->input->Name;
    }

    public function setType()
    {
        $this->inputSettings->type = $this->input->Type;
        switch ($this->input->Type) {
            case 'string':
                $this->handleStringType();
                break;
            case 'enum':
                $this->handleEnumType();
                break;
            case 'file':
                $this->handleFileType();
                break;
        }
        if (str_starts_with(strtolower($this->inputSettings->id), '_rd')) {
            $this->inputSettings->type = 'radioBtn';
        }
    }

    public function setRegex()
    {
        $this->inputSettings->regex = $this->input->Expression ? 'regex=' . $this->input->Expression->Regex : '';
    }

    public function setRequired()
    {
        $this->inputSettings->required = ($this->input->Required) ? 'required' : '';
    }

    public function setWritable()
    {

        if (isset($this->parentInput)) {

            if ($this->parentInput->writable && $this->input->Writable) {
                $this->inputSettings->writableProperty[$this->id] = $this->input->Writable;
                $this->inputSettings->writable = '';
                return true;
            }
        } else {
            if ($this->input->Writable) {
                $this->inputSettings->writableProperty[$this->id] = $this->input->Writable;
                $this->inputSettings->writable = '';
                return true;
            }
        }
        $this->inputSettings->writableProperty[$this->id] = false;
        $this->inputSettings->writable = 'disabled="disabled"';
        return true;
    }

    public function setPlaceholder()
    {
        $this->inputSettings->placeholder = $this->input->Placeholder ?? '';
    }

    public function setHidden()
    {
        $this->inputSettings->hidden = str_contains(strtolower($this->id), 'hiden') ? "d-none" : '';
    }

    public function setValue()
    {
        switch ($this->input->Type) {
            case 'money':
                $this->inputSettings->value = isset($this->input->Value) ? (isJson($this->input->Value) && !is_numeric($this->input->Value) ? json_decode($this->input->Value)->digitC : number_format($this->input->Value)) : null;
                break;
            case 'file':
                break;
            default:
                $this->inputSettings->value = $this->input->Value ?? null;
                break;
        }
    }

    public function setHasError()
    {
        $this->inputSettings->hasError = '';
    }

    public function setWritableValueBoolean()
    {
        $this->inputSettings->writableValueBoolean = $this->input->Writable;
    }

    private function handleStringType()
    {
        if (str_contains(strtolower($this->inputSettings->key), '_ymdatetime_')) {
            $this->prepareDatePickerComponent();
        }
        if (str_contains(strtolower($this->inputSettings->key), 'carplaqueir')) {
            $this->preparePlaqueComponent();
        }
        if (strtolower($this->inputSettings->key) == 'id') {
            $this->inputSettings->type = 'id';
        }
    }

    private function handleEnumType()
    {
        $this->inputSettings->values = $this->input->Values;
        $this->inputSettings->enumSelect = (str_starts_with(strtolower($this->id), 'selectwithfilter')) ? 'select2Component' : '';
    }

    private function handleMoneyType()
    {
        $this->inputSettings->value = number_format($this->input->Value);
    }

    private function prepareDatePickerComponent(): void
    {
        $this->inputSettings->component = "pdpDefault";
        $this->inputSettings->disabled = "";
        if (strpos(strtolower($this->id), 'birthdate') > 0) {
            $this->inputSettings->component = "pdpBirthday";
        } elseif (strpos(strtolower($this->id), 'fromdate')) {
            $this->inputSettings->component = "pdpFromDate";
        } elseif (strpos(strtolower($this->id), 'todate')) {
            $this->inputSettings->component = "pdpToDate";
            $this->inputSettings->disabled = 'readonly="readonly"';
        }
        $this->inputSettings->value = isset($this->input->Value) ? prepareDateForShow($this->input->Value) : null;
        $this->inputSettings->type = "datePicker";
    }

    private function preparePlaqueComponent(): void
    {
        $this->inputSettings->values = ['ه', 'و', 'ن', 'م', 'ل', 'ق', 'ط', 'س', 'د', 'ج', 'ب', 'الف', 'ی', 'ت', 'ژ', 'معلولین'];
    }

    public function getResult()
    {
        return $this->inputSettings;
    }

    public function setLaravelValidation()
    {
        if ($this->input->Writable && isset($this->input->validator)) {
            $validationIndex = $this->id;
            if ($this->input->Required) {
                $this->inputSettings->validator['rules'][$validationIndex][] = 'required';
            }
            $this->inputSettings->validator['rules'][$validationIndex] = $this->input->validator != null ? (json_decode($this->input->validator) != null ? json_decode($this->input->validator) : []) : [];
            $this->inputSettings->validator['attributes'][$validationIndex] = $this->input->Name . " در بخش " . $this->input->Name;
        }
    }

    public function setReadable()
    {
        $this->inputSettings->readable = $this->input->Readable;
    }

    private function handleFileType()
    {
        if (str_contains(strtolower($this->id), 'video')) {
            $this->inputSettings->isVideo = true;
        } else {
            $this->inputSettings->isVideo = false;
        }

        if ($this->input->File?->downloadable) {
            $this->inputSettings->downloadable = isset($this->input->File->downloadLink) ? $this->input->File->downloadLink : route('process.download.file', ['filename' => $this->input->File->fileName, 'variable' => $this->id]);
        }
        if (isset($this->input->File)) {
            if ($this->input->File->downloadLink) {
                $this->inputSettings->hasFile = $this->input->File->downloadLink;
            } else {

                $this->inputSettings->hasFile = preparePlatformFile($this->input->File);
            }
        }

        if (isset($this->input->Value)) {
            $file = json_decode($this->input->Value);
            if ($file == null && str_contains($this->input->Value, 'base64')) {
                $this->inputSettings->value = $this->input->Value;
            }
            if ($this->id == 'SabtImage') {
                $contentType = 'data:image/png;base64,';
                $this->inputSettings->value = str_contains($this->input->Value, 'base64') ? $this->input->Value : $contentType . $this->input->Value;

            }
            if (isset($file->fileName) && $file->fileName != '') {
                $this->inputSettings->fileName = $file->fileName;
                $this->inputSettings->value = prepareLinkDownload($this->id, $file->fileName);
                $this->inputSettings->defaultValue = $this->input->Value;
            }

        }
    }
}
