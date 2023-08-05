<?php

namespace Pkkbkraa\LaravelLivewireForms;

use Illuminate\Support\Arr;

class BaseField
{
    protected $name;
    protected $type;
    protected $input_type;
    protected $textarea_rows;
    protected $options;
    protected $default;
    protected $autocomplete;
    protected $placeholder;
    protected $help;
    protected $rules;
    protected $view;
    protected $format;
    protected $range;
    protected $time;

    public function __get($property)
    {
        return $this->$property;
    }

    public function input($type = 'text')
    {
        $this->type = 'input';
        $this->input_type = $type;
        return $this;
    }

    public function textarea($rows = 2)
    {
        $this->type = 'textarea';
        $this->textarea_rows = $rows;
        return $this;
    }

    public function select($options = [])
    {
        $this->type = 'select';
        $this->options($options);
        return $this;
    }

    public function multipleSelect($options = [])
    {
        $this->type = 'multiple_select';
        $this->options($options);
        return $this;
    }

    public function checkbox()
    {
        $this->type = 'checkbox';
        return $this;
    }

    public function switch()
    {
        $this->type = 'switch';
        return $this;
    }

    public function checkboxes($options = [])
    {
        $this->type = 'checkboxes';
        $this->options($options);
        return $this;
    }

    public function radio($options = [])
    {
        $this->type = 'radio';
        $this->options($options);
        return $this;
    }

    public function datepicker()
    {
        $this->type = 'datepicker';
        return $this;
    }

    public function format($format)
    {
        $this->format = $format;
        return $this;
    }

    public function range()
    {
        $this->range = true;
        return $this;
    }

    public function time()
    {
        $this->time = true;
        return $this;
    }

    protected function options($options)
    {
        $this->options = Arr::isAssoc($options) ? array_flip($options) : array_combine($options, $options);
    }

    public function default($default)
    {
        $this->default = $default;
        return $this;
    }

    public function autocomplete($autocomplete)
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function help($help)
    {
        $this->help = $help;
        return $this;
    }

    public function rules($rules)
    {
        $this->rules = $rules;
        return $this;
    }

    public function view($view)
    {
        $this->view = $view;
        return $this;
    }
}
