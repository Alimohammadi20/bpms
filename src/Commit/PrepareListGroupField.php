<?php

namespace App\Services\BPMS2\Commit;

use App\Services\BPMS2\Http\Requests\ProcessRequest;

class PrepareListGroupField extends PropertyChecker
{

    public function __construct(ProcessRequest $request)
    {
        parent::__construct($request,'listGroupFields');
    }

    public function handle($property)
    {
        if ($this->request->groupList != null) {
            foreach ($this->request->groupList as $propertyKey => $formProperty) {
                $groupFieldStruct = json_decode($this->structs[$propertyKey]->value);
                $groupFieldStruct->data = [];
                foreach ($formProperty as $groupListKey => $groupLists) {
                    foreach ($groupLists as $groupKey => $groupList) {
                        foreach ($groupList as $key => $formValue) {
                            if (in_array($key, $this->isWritable[$propertyKey][$groupListKey])) {
                                $keyOfRequest = "groupList.{$propertyKey}.{$groupListKey}.{$groupKey}.{$key}";
                                if (str_starts_with($key, '_huge_')) {
                                    $variableName = $this->generateVariableName($groupListKey, $groupKey, $key);
                                    $keyFile = $this->generatePropertyKey($propertyKey, $groupListKey, $groupKey, $key);
                                    $this->handleUploadLargeFile($tempTable[$propertyKey], $keyFile, $variableName);
                                    $this->handleUploadLargeFile($groupFieldStruct->data[$groupListKey][$groupKey][$key], $keyFile, $variableName);
                                } else {
                                    $this->handleDateInput($groupFieldStruct->data[$groupListKey][$groupKey][$key], $key, $formValue);
                                    $this->handleStringInput($groupFieldStruct->data[$groupListKey][$groupKey][$key], $key, $formValue);
                                }
                            }
                        }
                    }
                }
            }
            $this->request->setNewValue('listGroupFields', $propertyKey, $groupFieldStruct);
            $property[$propertyKey] = json_encode($groupFieldStruct);
        }
        $this->next($property);
    }

    private function generatePropertyKey($propertyKey, $groupListKey, $groupKey, $key)
    {
        return 'groupList.' . $propertyKey . '.' . $groupListKey . '.' . $groupKey . '.' . $key;
    }

    private function generateVariableName($groupListKey, $groupKey, $key)
    {
        return 'Table$' . $groupListKey . '_' . $groupKey . '_' . $key;
    }
}
