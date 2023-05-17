<?php

namespace App\Services\BPMS2\Commit;

use App\Services\BPMS2\Http\Controllers\UserProcessController;
use App\Services\BPMS2\Http\Requests\ProcessRequest;

abstract class PropertyChecker
{
    protected $successor;
    protected array $structs;
    protected array $isWritable;
    protected ProcessRequest $request;
    protected UserProcessController $process;

    public function __construct(ProcessRequest $request, $type = '')
    {
        $this->request = $request;
        $this->process = new UserProcessController();
        $this->isWritable = $request->getWrtiable($type);
        $this->structs = $request->getStruct($type);
    }

    abstract public function handle($property);

    public function succeedWith(PropertyChecker $successor)
    {
        $this->successor = $successor;
    }

    public function next($property)
    {
        if (isset($this->successor)) {
            $this->successor->handle($property);
        }
    }

    protected function handleUploadLargeFile(&$property, $key, $variableName)
    {
        if ($this->request->hasFile($key)) {
            $file = $this->request->file($key);
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $extension = ($extension != 'pdf') ? 'png' : 'pdf';
            $file_name_table = $variableName . "." . $extension;
            $this->process->uploadLargeFile($file_name_table, base64_encode(file_get_contents($file)), $variableName);
            $property = json_encode(['bytes' => '', 'fileName' => $file_name_table]);
        } else {
            $property = json_encode(['bytes' => '', 'fileName' => ""]);
        }
    }

    protected function handleStringInput(&$property, $key, $propertyValue): void
    {
        $value = toEnglishNumber($propertyValue);
        if (str_contains($propertyValue, ',')) {
            if (is_numeric($value)) {
                $value = json_encode([
                    'digit' => $value,
                    'digitC' => number_format($value),
                    'letter' => '',
                ]);
            }
        }
        $property = $value;
    }

    protected function handleDateInput(&$property, $key, $propertyValue): void
    {
        if (str_starts_with(strtolower($key), "_ymdatetime_")) {
            $property = prepareDateForSendMiladi($propertyValue);
        }
    }
}
