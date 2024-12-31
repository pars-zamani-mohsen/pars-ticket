<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class RichText extends Component
{
    public string $name;
    public ?string $label;
    public ?string $value;
    public ?string $placeholder;
    public bool $required;

    public function __construct(
        string $name,
        ?string $label = null,
        ?string $value = null,
        ?string $placeholder = null,
        bool $required = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.forms.rich-text');
    }
}
