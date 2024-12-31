<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatePicker extends Component
{
    public $name;
    public $label;
    public $value;
    public $id;

    public function __construct($name, $label = null, $value = null, $id = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->id = $id ?? str_replace(['[', ']'], ['_', ''], $name);
    }

    public function render()
    {
        return view('components.date-picker');
    }
}
