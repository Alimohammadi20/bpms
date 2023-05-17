<?php

namespace App\Services\BPMS2\Commit;

use App\Services\BPMS2\Http\Requests\ProcessRequest;

class PrepareTable extends PropertyChecker
{
    public function __construct(ProcessRequest $request)
    {
        parent::__construct($request, 'tables');
    }

    public function handle($property)
    {
        if ($this->request->table != null) {
            foreach ($this->request->table as $tableKey => $rows) {
                if (isset($this->isWritable[$tableKey][$tableKey]) && count($this->isWritable[$tableKey]) > 1) {
                    $tableStruct = $this->structs[$tableKey];
                    $tableStruct->value->Data = $tempTable = [];
                    foreach ($rows as $rowKey => $row) {
                        foreach ($row as $propertyKey => $propertyValue) {
                            if (str_starts_with($propertyKey, '_huge_')) {
                                $key = $this->generatePropertyKey($tableKey, $rowKey, $propertyKey);
                                $variableName = $this->generateVariableName($tableKey, $rowKey, $propertyKey);
                                $this->handleUploadLargeFile($tempTable[$propertyKey], $key, $variableName);
                            } else {
                                $this->handleDateInput($tempTable[$propertyKey], $propertyKey, $propertyValue);
                                $this->handleStringInput($tempTable[$propertyKey],$propertyKey, $propertyValue);
                            }
                        }
                        $tableStruct->value->Data[] = $tempTable;
                    }
                    $this->request->setNewValue('tables', $tableKey, $tableStruct->value);
                    $property[$tableKey] = json_encode($tableStruct->value);
                }
            }
            $this->unSetProperties($property);
        }
        $this->next($property);
    }

    private function unSetProperties(&$property)
    {
        unset($property['table'], $property["lastRowTable"]);
    }

    private function generatePropertyKey($tableKey, $rowKey, $propertykey)
    {
        return 'table.' . $tableKey . '.' . $rowKey . '.' . $propertykey;
    }

    private function generateVariableName($tableKey, $rowKey, $propertykey)
    {

        return $tableKey . '_' . $rowKey . '_' . $propertykey;
    }
}
