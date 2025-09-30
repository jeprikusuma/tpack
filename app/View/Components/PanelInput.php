<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PanelInput extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public $name;
    public $label;
    public $value;
    public $required;
    public $disabled;
    public $isFull;
    public $max;
    public $min;

    public function __construct(
        $type = 'text', 
        $name, 
        $label = null, 
        $value = null, 
        $required = false,
        $disabled = false,
        $isFull = false,
        $max = null,
        $min = null
    )
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->isFull = $isFull;
        $this->max = $max;
        $this->min = $min;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.panel-input');
    }
}
