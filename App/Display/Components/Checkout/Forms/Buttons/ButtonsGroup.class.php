<?php

declare(strict_types=1);

class ButtonsGroup //extends AbstractCheckoutformSteps
{
    public function __construct(private ?object $frm = null)
    {
    }

    public function buttonsGroup(string $type = '', ?string $text = null) : string
    {
        list($btnType, $content, $class) = $this->btnType($type);

        return '  <div class="input-box mb-3 btns-group">' . $this->frm->input([
            ButtonType::class => ['type' => $btnType, 'class' => ['btn', $class, 'k-text-white']],
        ])->content($text == null ? $content : $text)->html() . '</div>';
    }

    private function btnType(string $type) : array
    {
        return match ($type) {
            'next' => ['button', 'Next', 'btn-next'],
            'prev' => ['button', 'Previous', 'btn-prev'],
            default => ['submit', 'Submit', 'btn-submit']
        };
    }
}
