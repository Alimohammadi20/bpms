<?php

namespace App\Services\BPMS2\Objects;

class ListGroupFieldInputSettings extends GroupFieldInputSettings
{
    protected InputSettings $inputSettings;
    private mixed $input;
    private string $id;

    public function __construct($input, $id)
    {
        parent::__construct($input, $id);
        $this->id = $id;
        $this->input = $input;
        $this->inputSettings = new InputSettings();
    }

    public function setType()
    {
        $this->inputSettings->type = 'ListGroupField';
    }


    public function setValue()
    {
        $director = new InputSettingsDirector();
        $collect = collect();
        $inputs = json_decode($this->input->value);
        if ($inputs) {
            if ($inputs) {
                $writableProperty = [];
                foreach ($inputs->groupItems as $groupFieldKey => $groupFieldProperty) {
                    $groupfield = $items = collect();
                    foreach ($groupFieldProperty as $key => $property) {
                        $id = 'groupList['.$this->id.'][' . $groupFieldKey . '][@index][' . $key . ']';
                        $formProperty = $director->build(new InputSettingsBase($property, $id, $key));
                        if (isset($formProperty->validator)) {
                            $validatorId = 'groupList['.$this->id.'][' . $groupFieldKey . '][*][' . $key . ']';
                            $this->inputSettings->validator['rules'][$validatorId] = $formProperty->validator['rules'][$id];
                            $this->inputSettings->validator['attributes'][$validatorId] = $formProperty->validator['attributes'][$id];
                        }
                        if ($formProperty->writableProperty[$id]) {
                            $writableProperty[$this->id][$groupFieldKey][] = $key;
                        }
                        $items->put($key, $formProperty);
                        $groupfield->name = $inputs->items->{$groupFieldKey};
                        $groupfield->id = $groupFieldKey;
                    }

                    $groupfield->formProperties = $items;
                    $collect->put($groupFieldKey, $groupfield);
                }
            }
        }
        $this->inputSettings->listGroupFieldWrtiable = $writableProperty;
        $this->inputSettings->values = $inputs->items;
        $this->inputSettings->formProperties = $collect;
    }

    public function setWritable()
    {
        $this->inputSettings->writableProperty = $this->inputSettings->listGroupFieldWrtiable;
    }

}
