<?php

namespace App\Services\BPMS2\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class ProcessRequest extends FormRequest
{
    public $rules = [];
    private array $writable;
    public array $structs;
    private string $taskId;
    public $oldDataForCommit;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return session('taskValidation') != null ? session('taskValidation') : [];
    }

    public function attributes()
    {
        return isset($this->rules['attributes']) ? $this->rules['attributes'] : [];
    }

    public function handleSubmitForm()
    {
        return $this->handleNextSubmit($this->all());
    }

    private function handleNextSubmit(): array
    {
        $dynamic_form_values = $this->except('_token', 'Back', 'submit_btn');
        $isWritable = session('writeable_or_not_property');
        foreach ($dynamic_form_values as $key => $value) {
            if (isset($isWritable[$key]) && $isWritable[$key]) {
                if (is_string($value) && str_contains($value, ',')) {
                    $dynamic_form_values[$key] = str_replace(',', '', $value);
                }
                if ($key != "groupList" && $key != "table") {
                    $dynamic_form_values[$key] = toEnglishNumber($value);
                }
                if (str_starts_with($key, '_huge_') && $this->hasFile($key)) {
                    $extension = pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION);
                    $file_name = $key . "." . $extension;
                    $this->uploadLargeFile($file_name, base64_encode(file_get_contents($value)), $key);
                    $dynamic_form_values[$key] = json_encode(['bytes' => '', 'fileName' => (isset($file_name)) ? $file_name : '']);
                }
            } else if ($key != "groupList" && $key != "table") {
                unset($dynamic_form_values[$key]);
            }
        }
        if ($this->submit_btn == 'cancel') {
            $dynamic_form_values['Cancel'] = true;
        }
        if ($this->submit_btn == 'back') {
            $dynamic_form_values['Back'] = true;
        }
        if ($this->submit_btn == 'next') {
            $dynamic_form_values['ApproveButton'] = true;
        }
        return $dynamic_form_values;
    }

    private function initProperties()
    {
        $properties = Cache::get('bpms2.process.' . auth()->user()->userName . '_' . $this->taskId);
        $this->structs = $properties['structs'];
        $this->writable = $properties['writable'];
        $this->rules = $properties['validations'];
        $this->original = $properties['original'];
    }

    private function initPropertiesForBack()
    {
        $properties = Cache::get('bpms2.process.' . auth()->user()->userName . '_' . $this->taskId);
        $this->structs = [];
        $this->writable = $properties['writable'];
        $this->rules = [];
        $this->original = [];
    }

    protected function prepareForValidation(): void
    {
        $this->taskId = $this->route('task_id') !== null ? $this->route('task_id') : (session('task') != null ? session('task')->id : '');
        switch ($this->get('submit_btn')) {
            case 'next':
                $this->initProperties();
                break;
            case 'cancel':
            case 'back':
                $this->initPropertiesForBack();
                break;
        }
    }

    public function messages()
    {
        return Lang::get('process-validation-messages.process-validation');
    }

    public function getStruct($type)
    {
        return $this->structs[$type] ?? [];
    }

    public function getWrtiable($type)
    {
        return $this->writable[$type] ?? [];
    }

    public function getTaskId()
    {
        return $this->taskId;
    }

    public function setNewValue($type, $id, $value)
    {
        if ($this->oldDataForCommit == null) {
            $data = collect(['tables' => collect(), 'listGroupFields' => collect(), 'inputs' => collect()]);
        } else {
            $data = $this->oldDataForCommit;
        }
        $data->get($type)->put($id, $value);
        $this->oldDataForCommit = $data;
    }

    public function insertNewValueToSession()
    {
        session(['oldDataCommitted' => $this->oldDataForCommit]);

    }

    public function forgetValuesSession()
    {
        session()->forget('oldDataCommitted');
    }

    public function forgetFormPropertiesCache()
    {
        $cacheKey = 'bpms2.process.' . auth('web')->user()->userName . '_' . $this->taskId;
        Cache::forget($cacheKey);
    }

    public function deleteFileDirectory()
    {
        Storage::disk('process')->directories('/process/' . $this->taskId);
    }
}
