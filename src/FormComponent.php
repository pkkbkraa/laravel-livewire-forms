<?php

namespace Kdion4891\LaravelLivewireForms;

use Illuminate\Support\Arr;
use Kdion4891\LaravelLivewireForms\Traits\FollowsRules;
use Kdion4891\LaravelLivewireForms\Traits\HandlesArrays;
use Kdion4891\LaravelLivewireForms\Traits\UploadsFiles;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class FormComponent extends Component
{
    use FollowsRules, UploadsFiles, HandlesArrays, LivewireAlert, WithFileUploads;

    public $model, $field, $key, $type;
    public $form_data;
    private static $storage_disk;
    private static $storage_path;

    protected $listeners = ['fileUpdate', 'confirmed'];

    public function mount($model = null)
    {
        $this->setFormProperties($model);
    }

    public function setFormProperties($model = null)
    {
        $this->model = $model;
        if ($model) $this->form_data = $model->toArray();

        foreach ($this->fields() as $field) {
            if (!isset($this->form_data[$field->name])) {
                $array = in_array($field->type, ['checkboxes', 'file']);
                $this->form_data[$field->name] = $field->default ?? ($array ? [] : null);
            }
        }
    }

    public function render()
    {
        return $this->formView();
    }

    public function formView()
    {
        return view('laravel-livewire-forms::form', [
            'fields' => $this->fields(),
        ]);
    }

    public function fields()
    {
        return [
            Field::make('Name')->input()->rules(['required', 'string', 'max:255']),
            Field::make('Email')->input('email')->rules(['required', 'string', 'email', 'max:255', 'unique:users,email']),
            Field::make('Password')->input('password')->rules(['required', 'string', 'min:8', 'confirmed']),
            Field::make('Confirm Password', 'password_confirmation')->input('password'),
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules(true));
    }

    public function submit()
    {
        $this->validate($this->rules());

        $field_names = [];
        foreach ($this->fields() as $field)
        {
            $field_names[] = $field->name;
            if($field->type == 'file')
            {
                foreach($this->form_data[$field->name] ?? [] as $key => $value)
                {
                    $value->store($this->storage_path.'/'.date('Ymd'));
                }
            }
        }
        $this->form_data = Arr::only($this->form_data, $field_names);


        $this->success();
    }

    public function errorMessage($message)
    {
        return str_replace(['form data.', 'form_data.'], '', $message);
    }

    public function success()
    {
        $this->form_data['password'] = bcrypt($this->form_data['password']);

        \App\User::create($this->form_data);
    }

    public function saveAndStay()
    {
        $this->submit();
        $this->saveAndStayResponse();
    }

    public function saveAndStayResponse()
    {
        return redirect()->route('users.create');
    }

    public function saveAndGoBack()
    {
        $this->submit();
        $this->saveAndGoBackResponse();
    }

    public function saveAndGoBackResponse()
    {
        return redirect()->route('users.index');
    }

    public function closeForm()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function confirmed()
    {
        $this->arrayRemove($this->field, $this->key);
    }

    public function confirm($field, $key)
    {
        $this->field = $field;
        $this->key = $key;
        $this->alert('warning', '確認刪除?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'confirmButtonText' => '確認',
            'cancelButtonText' => '取消',
            'position' => 'center',
            'onConfirmed' => 'confirmed',
            'cancelButtonColor' => '#ee6352',
            'timer' => null,
        ]);
    }
}
