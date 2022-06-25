<?php

declare(strict_types=1);

class ButtonsGroup extends AbstractFormSteps
{
    public function __construct(private ?object $frm = null, private ?object $obj = null)
    {
    }

    public function buttonsGroup(bool $submit = false) : string
    {
        $buttonTemplate = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_button_group.php';
        $this->isFileexists($buttonTemplate);
        $buttonTemplate = file_get_contents($buttonTemplate);
        $btn_prev = $this->frm->input([
            ButtonType::class => ['type' => 'button', 'class' => ['btn', 'btn-prev', 'k-text-white']],
        ])->content('Previous')->html();
        if (!$submit) {
            $btnType = 'button';
            $content = 'Next';
        } else {
            $btnType = 'submit';
            $content = 'Submit';
        }
        $btnType = !$submit ? 'button' : 'submit';
        $btn_next = $this->frm->input([
            ButtonType::class => ['type' => $btnType, 'class' => ['btn', 'btn-next', 'k-text-white']],
        ])->content($content)->html();
        $buttonTemplate = str_replace('{{buttonsContent}}', $btn_prev . "\n" . $btn_next, $buttonTemplate);
        return $buttonTemplate;
    }
}