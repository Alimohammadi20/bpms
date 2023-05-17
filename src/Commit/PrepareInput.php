<?php

namespace App\Services\BPMS2\Commit;

use App\Services\BPMS2\Http\Requests\ProcessRequest;

class PrepareInput extends PropertyChecker
{


    public function __construct(ProcessRequest $request)
    {
        parent::__construct($request, 'inputs');
    }

    public function handle($property = [])
    {
        $property = $this->request->only($this->isWritable);
        foreach ($property as $key => $value) {
            if (str_starts_with($key, '_huge_')) {
                $this->handleUploadLargeFile($property[$key], $key, $key);
            } else {
                $this->handleStringInput($property[$key], $key, $value);
                $this->handleDateInput($property[$key], $key, $value);
            }
            $this->request->setNewValue('inputs', $key, $property[$key]);
        }

        switch ($this->request->submit_btn) {
            case 'cancel':
                $property['Cancel'] = 'true';
                $property['ApproveButton'] = 'false';
                $property['Back'] = 'false';
                break;
            case 'back':
                $property['Back'] = 'true';
                $property['ApproveButton'] = 'false';
                $property['Cancel'] = 'false';
                break;
            case 'next':
                $property['ApproveButton'] = 'true';
                $property['Cancel'] = 'false';
                $property['Back'] = 'false';

                break;
        }
        $this->next($property);
    }
}
