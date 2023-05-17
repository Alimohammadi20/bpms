<?php

namespace App\Services\BPMS2\Commit;

use App\Services\BPMS2\Http\Requests\ProcessRequest;

class CommitRequest extends PropertyChecker
{
    private string $taskId;
    private mixed $response;

    public function __construct(ProcessRequest $request)
    {
        parent::__construct($request);
        $this->taskId = $request->getTaskId();
    }


    public function handle($property)
    {
        $this->request->insertNewValueToSession();
        $response = $this->process->commitRequest($this->taskId, $property);
        $this->response = $response;
    }
    public function getRespons()
    {
        return $this->response;
    }

}
