<?php

namespace App\Services\BPMS2\Http\Controllers;

use App\Models\User;
use App\Services\BPMS2\Commit\CommitRequest;
use App\Services\BPMS2\Commit\PrepareInput;
use App\Services\BPMS2\Commit\PrepareListGroupField;
use App\Services\BPMS2\Commit\PrepareTable;
use App\Services\BPMS2\enums\HttpMethod;
use App\Services\BPMS2\Http\ProcessBaseClass;
use App\Services\BPMS2\Objects\GroupFieldInputSettings;
use App\Services\BPMS2\Objects\InputSettingsDirector;
use App\Services\BPMS2\Objects\InputSettingsSimple;
use App\Services\BPMS2\Objects\ListGroupFieldInputSettings;
use App\Services\BPMS2\Objects\TableInputSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;

class UserProcessController extends ProcessBaseClass
{
    private string $baseUrl;
    private string|null $userPlatformAuth;
    private User|null $user;

    public function __construct()
    {
        $this->baseUrl = config('process.platform_base_url');
        $this->userPlatformAuth = session('platformToken') ?? null;
        $this->user = auth('web')->user();
        parent::__construct($this->baseUrl, $this->userPlatformAuth, $this->user->userName);
    }

    public function commitProcess($request)
    {
        $prepareInput = new PrepareInput($request);
        $prepareListGroupField = new PrepareListGroupField($request);
        $prepareTable = new PrepareTable($request);
        $commitRequest = new CommitRequest($request);
        $prepareInput->succeedWith($prepareListGroupField);
        $prepareListGroupField->succeedWith($prepareTable);
        $prepareTable->succeedWith($commitRequest);
        $prepareInput->handle($request);
        return $commitRequest->getRespons();
    }

    public function commitRequest($task_id, $property): LazyCollection
    {
        $commit_request_url = str_replace(':task-id', $task_id, config('process.commit_task'));
        return parent::method(HttpMethod::POST)->url($commit_request_url)->data($property)->execute();
    }

    public function taskDetailProcess($task_id)
    {
        $cacheKey = 'bpms2.process.' . $this->user->userName . '_' . $task_id;
        $taskDetails = Cache::get($cacheKey);
        if (!$taskDetails) {
            $taskDetails = Cache::remember($cacheKey, 2 * 60 * 60, function () use ($task_id) {
                session()->forget('taskRedirectRouteName');
                $get_task_details = str_replace(':task-id', $task_id, config('process.get_task_details'));
                $response = parent::method(HttpMethod::GET)->url($get_task_details)->execute();
                if ($response->get('status')) {
                    return $this->prepareFormProperties($response->get('response')->formProperties);
                } else {
                    return $response;
                }
            });
            if (isset($taskDetails['status'])) {
                Cache::forget($cacheKey);
            } else {
                setCacheKey($cacheKey);
            }
        }
        return $taskDetails;
    }


    private function prepareFormProperties($form_properties, $isFormData = false): array
    {
//        dd($form_properties);
        $director = new InputSettingsDirector();
        $form_properties = (isset($form_properties)) ? $form_properties : [];
        $tableStruct = $groupFieldStruct = array();
        $isWritable = ['tables' => [], 'inputs' => [], 'listGroupFields' => []];
        $validation = ['rules' => [], 'attributes' => []];
        $inputArrayId = ['Back', 'Cancel', 'DescriptionForm', '_inquiryInfo_Reciept','ApproveButton'];
        $all_form_properties = $this->assigneeDetect($isFormData);
        if (count($form_properties) > 0 && $form_properties !== null) {
            foreach ($form_properties as $key => $property) {
                $form_properties[$property->id] = $property;
                $component = explode("$", $property->id);
                $property->type_name = $property->type->name;
                $property->type_value = $property->type->value;
                if (count($component) == 1) {
                    $property = $director->build(new InputSettingsSimple($property, $property->id));
                    if ($property->id == "_inquiryInfo_Reciept") {
                        $property->value = json_decode($property->value);
                    }
                    if (in_array($property->id, $inputArrayId)) {
                        $all_form_properties[$property->id] = $property;
                    } else {
                        $all_form_properties['input'][$property->id] = $property;
                    }
                } else {
                    if ($property->value != null) {
                        switch ($component[0]) {
                            case "Table":
                                $tableStruct[$property->id] = $property;
                                $property = $director->build(new TableInputSettings($property, $property->id));
                                $all_form_properties['tables'][$property->id] = $property;
                                break;
                            case "ListGroupField":
                                $groupFieldStruct[$property->id] = $property;
                                $property = $director->build(new ListGroupFieldInputSettings($property, $property->id));
                                $all_form_properties['input'][$property->id] = $property;
                                break;
//                            case "Calculator":
                            case "GroupField":
                                $property = $director->build(new GroupFieldInputSettings($property, $property->id));
                                $all_form_properties['input'][$property->id] = $property;
                                break;
                            case "Hidden_Url":
                                session(['payment_integration' => $property->value]);
                                break;
                            case "Hidden_PaymentResult":
                                $all_form_properties[$component[0]] = $property;
                                break;
                            case "Hidden_Initiator":
                            case "Hidden_TotalAmount":
                                $all_form_properties['input'][$property->id] = $property;
                                break;
                            case "Redirect":
                                $redirect = json_decode($property->value);
                                session(['taskRedirectRouteName' => $redirect]);
                                break;
                            case "TEXTEDITOR":
                                $all_form_properties['textEditor'][$property->id] = $property;
                                break;
                            case "help":
                                $all_form_properties['helps'][$property->id] = $property;
                                break;
                            case "script":
                                $all_form_properties['scripts'][$property->id] = $property;
                                break;
                            case "Approve":
                                $all_form_properties['approve'] = $property;
                                break;
                            case "RD":
                            case "Back":
                            case "Accept":
                            case "YMDateTime":
                            case "HugeVideo":
                            case "HugeImage":
                            case "HugeDocument":
                            case "DescriptionForm":
                                $all_form_properties[$property->id] = $property;
                                break;
                            default:
                                Log::warning("Type Not Handled " . $property->id);
                        }
                    }
                }
                if (isset($property->validator['rules'])) {
                    $validation['rules'] = array_merge($validation['rules'], $property->validator['rules']);
                    $validation['attributes'] = array_merge($validation['attributes'], $property->validator['attributes']);
                }
                if (isset($property->writableProperty)) {
                    switch ($property->type) {
                        case 'table':
                            $isWritable['tables'] = array_merge($isWritable['tables'], $property->writableProperty['table']);
                            break;
                        case 'listGroupField':
                        case 'groupField':
                            $isWritable['listGroupFields'] = array_merge($isWritable['groupField'], $property->writableProperty);
                            break;
                        default:
                            if (count($property->writableProperty) > 0 && isset($property->writableProperty['input'])) {
                                $isWritable['inputs'] = array_merge($isWritable['inputs'], $property->writableProperty['input']);
                            }
                            break;
                    }
                }
                unset($form_properties[$key]);
            }
        }
        return [
            'prepared' => parent::toCollection($all_form_properties),
            'original' => $form_properties,
            'validations' => $validation,
            'writable' => $isWritable,
            'structs' => [
                'tables' => $tableStruct,
                'listGroupFields' => $groupFieldStruct
            ]
        ];
    }


    private function assigneeDetect($isFormData): array
    {
        $assignee = session('taskAssignee');
        if (!$isFormData) {
            if ($assignee != null && checkAsignee($assignee)) {
                $all_form_properties['agentProcess'] = false;
            } else {
                $all_form_properties['agentProcess'] = true;
            }
        } else {
            $all_form_properties['agentProcess'] = false;
        }
        return $all_form_properties;
    }


    public function nextActiveProcess($process_instance_id): array
    {
        $next_active_task_request_url = str_replace(':process-instance-id', $process_instance_id, config('process.next_active_task'));
        $response = parent::method(HttpMethod::GET)->url($next_active_task_request_url)->execute();
        if (isset($response->get('response')->tasks) && $response->get('response')->tasks) {
            if (count($response->get('response')->tasks) == 0) {
                $res = [
                    'status' => $response->get('status'),
                    'taskDone' => true,
                ];
            } elseif (isset($response->get('response')->tasks[0])) {
                $res = [
                    'status' => $response->get('status'),
                    'assignee' => $response->get('response')->tasks[0]->assignee,
                    'task' => $response->get('response')->tasks[0]
                ];
            } else {
                $res = [
                    'status' => $response->get('status'),
                    'task' => $response->get('response')
                ];
            }

            session(['task' => $res['task']]);
            session(['taskAssignee' => $res['task']->assignee]);
            return $res;
        }
        $res = [
            'taskDone' => true,
            'status' => $response->get('status')
        ];
        session(['task' => $res]);
        return $res;
    }


    public function startFormData($process_instance_id): array
    {
        $get_form_data = str_replace(':process-instance-id', $process_instance_id, config('process.form_data'));
        $response = parent::method(HttpMethod::GET)->url($get_form_data)->execute();

        session(['cartableTask' => $response->get('response')->processDefinition]);
        return $this->prepareFormProperties($response->get('response')->formProperties, true);
    }


    public function getUserTasks($params = []): LazyCollection
    {
        $get_user_tasks = config('process.get_cardboard');
        $response = parent::method(HttpMethod::GET)->url($get_user_tasks)->params($params)->execute();
        if ($response->get('status')) {
            if ($response->get('response')->total > 0) {
                $count = $response->get('response')->total;
                session(['user_task_count' => $count]);
                return parent::toCollection([
                    'status' => $response->get('status'),
                    'tasks' => $response->get('response')->data
                ]);
            }
        }
        return parent::toCollection([
            'status' => $response->get('status'),
            'tasks' => []
        ]);
    }



    public function getUserProcesses($start = 0, $size = 50000, $order = 'asc'): array
    {
        $get_user_tasks = config('process.get_user_processes');
        $data = ['start' => $start, 'size' => $size, 'order' => $order];
        $response = parent::method(HttpMethod::GET)->url($get_user_tasks)->params($data)->execute();
        return [
            'status' => $response->get('status'),
            'processes' => $response->get('response')->data ?? []
        ];
    }


    public function uploadLargeFile($file_name, $fileByteArray, $variable_name): LazyCollection
    {
        $upload_large_file = str_replace([':process-instance-id', ':variable-name'], [session("task")->processInstanceId, $variable_name], config('process.upload_large'));
        $customer_file = ['fileName' => $file_name, 'bytes' => $fileByteArray];
        $response = parent::method(HttpMethod::POST)->url($upload_large_file)->data($customer_file)->execute();
        return $response;
    }

    public function downloadLargeFile($processInstanceId, $variableName): array
    {
        $dowload_large_file = str_replace([':process-instance-id', ':variable-name'], [$processInstanceId, $variableName], config('process.download_large_file'));
        $response = parent::method(HttpMethod::GET)->url($dowload_large_file)->execute();
        if ($response->get('status') && $response->get('response') != null) {
            $contents = base64_decode($response->get('response')->bytes);
            return [
                'status' => true,
                'fileName' => $response->get('response')->fileName,
                'bytes' => $contents,
            ];
        }
        return [
            'status' => false,
            'fileName' => null,
            'bytes' => null,
        ];
    }


    public function startWithFormProperty($process_id, $data): LazyCollection
    {
        $start_authentication = str_replace(':process-instance-id', $process_id, config('process.start'));
        return parent::method(HttpMethod::POST)->url($start_authentication)->data($data)->execute();
    }

    public function nextProcess($process_instance_id): array
    {
        $next_task_request_url = str_replace(':process-instance-id', $process_instance_id, config('next_task.start'));
        $response = parent::method(HttpMethod::GET)->url($next_task_request_url)->execute();
        if ($response['response']->tasks === null) {
            $res = [
                'status' => $response['status'],
                'taskDone' => true
            ];
        } elseif (isset($response['response']->tasks) && ($response['response']->tasks) > 0) {
            $res = [
                'status' => $response['status'],
                'task' => $response['response']->tasks[0]
            ];
        } else {
            $res = [
                'status' => $response['status'],
                'task' => $response['response']
            ];
        }
        return $res;
    }
}
