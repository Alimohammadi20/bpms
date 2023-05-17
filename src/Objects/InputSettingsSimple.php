<?php

namespace App\Services\BPMS2\Objects;

use App\Services\BPMS2\interfaces\InputSettingsBuilderInterface;

class
InputSettingsSimple implements InputSettingsBuilderInterface
{

    protected InputSettings $inputSettings;
    private mixed $input;
    private string $id;

    public function __construct($input, $id)
    {
        $this->id = $id;
        $this->input = $input;
        $this->inputSettings = new InputSettings();
        $this->inputSettings->key = $id;
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
        $this->inputSettings->type = $this->input->type->name;
        switch ($this->input->type->name) {
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
        $this->inputSettings->regex = $this->input->expression ? 'regex=' . $this->input->epression->Regex : '';
    }

    public function setRequired()
    {
        $this->inputSettings->required = ($this->input->required) ? 'required' : '';
    }

    public function setWritable()
    {
        if ($this->input->writable) {
            $this->inputSettings->writableProperty['input'][$this->id] = $this->id;
            $this->inputSettings->writable = '';
        } else {
            $this->inputSettings->writable = 'readonly="readonly"';
        }
    }

    public function setPlaceholder()
    {
        $this->inputSettings->placeholder = $this->input->placeholder ?? '';
    }

    public function setHidden()
    {
        $this->inputSettings->hidden = str_contains(strtolower($this->id), 'hiden') ? "d-none" : '';
    }

    public function setValue()
    {
        $this->inputSettings->value = $this->input->value;
    }

    public function setHasError()
    {
        $this->inputSettings->hasError = '';
    }

    public function setWritableValueBoolean()
    {
        $this->inputSettings->writableValueBoolean = $this->input->writable;
    }

    private function handleStringType()
    {
        if (str_contains(strtolower($this->id), '_ymdatetime_')) {
            $this->prepareDatePickerComponent();
        }
        if (str_contains(strtolower($this->id), 'carplaqueir')) {
            $this->preparePlaqueComponent();
        }
        if (str_contains(strtolower($this->id), '_inquiryinfo_')) {
            $this->prepareInquiryComponent();
        }
        if (str_contains(strtolower($this->id), '_qr_')) {
            $this->prepareQRComponent();
        }
    }

    private function handleEnumType()
    {
        $this->inputSettings->values = json_decode($this->input->type->value);
        $this->inputSettings->enumSelect = (str_starts_with(strtolower($this->id), 'selectwithfilter')) ? 'select2Component' : '';
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
        $this->inputSettings->type = 'datePicker';
    }

    private function preparePlaqueComponent(): void
    {
        $this->inputSettings->values = ['ه', 'و', 'ن', 'م', 'ل', 'ق', 'ط', 'س', 'د', 'ج', 'ب', 'الف', 'ی', 'ت', 'ژ', 'معلولین'];
    }
    private function prepareQRComponent(): void
    {
        $this->inputSettings->type = 'qrCode';
        $this->inputSettings->value = $this->input->value;
    }
    private function prepareInquiryComponent(): void
    {
        $this->inputSettings->type = 'inquiry';
        $this->inputSettings->value = $this->input->value;
    }

    public function getResult()
    {
        return $this->inputSettings;
    }

    public function setLaravelValidation()
    {
        if ($this->input->writable && isset($this->input->validator)) {
            $validationIndex = $this->id;
            if ($this->input->Required) {
                $this->inputSettings->validator->rules[$validationIndex][] = 'required';
            }
            $this->inputSettings->validator->rules[$validationIndex] = $this->input->validator != null ? (json_decode($this->input->validator) != null ? json_decode($this->input->validator) : []) : [];
            $this->inputSettings->validator->attributes[$validationIndex] = $this->input->name . " در بخش " . $this->input->name;
        }
    }

    public function setReadable()
    {
        $this->inputSettings->readable = $this->input->readable;
    }
    private function handleFileType()
    {
        if (str_contains(strtolower($this->id),'video')){
            $this->inputSettings->isVideo = true;
        }else{
            $this->inputSettings->isVideo = false;
        }
        if(isset($this->input->File) && $this->input->File->downloadable){
            $this->inputSettings->downloadable = isset($this->input->File->downloadLink) ? $this->input->File->downloadLink : route('process.download.file',['filename'=>$this->input->File->fileName,'variable'=>$this->id]);
        }
        if (isset($this->input->File)){
            if ($this->input->File->downloadLink){
                $this->inputSettings->hasFile =$this->input->File->downloadLink;
            }else{
                $this->inputSettings->hasFile = preparePlatformFile($this->input->File);
            }
        }else{
            $this->inputSettings->hasFile =null;
        }
        if (str_contains($this->input->value,'base64')){
            $this->inputSettings->value = $this->input->value;
        }
        $file = json_decode($this->input->value);
        if(isset($file->fileName) && $file->fileName != ''){
            $this->inputSettings->fileName = $file->fileName;
            $this->inputSettings->value =prepareLinkDownload($this->id,$file->fileName) ;
            $this->inputSettings->defaultValue =  $this->input->value;
        }
    }

}
