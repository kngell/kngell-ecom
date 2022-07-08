<?php

declare(strict_types=1);
abstract class AbstractCheckout
{
    public function __construct()
    {
    }

    protected function discountCode() : string
    {
        $template = $this->paths->offsetGet('mainDiscountPath');
        $this->isFileexists($template);
        $template = file_get_contents($template);
        $template = str_replace('{{codePromotion}}', $this->frm->input([
            TextType::class => ['name' => 'code_promotion', 'class' => ['input-box__input', 'me-2']],
        ])->Label('code promotion')->id('code_promotion__' . $this::class)->req()->placeholder(' ')->attr(['form' => 'discount-frm'])->labelClass(['input-box__label'])->html(), $template);

        $template = str_replace('{{button}}', $this->frm->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['btn', 'btn-highlight', 'waves-effect']],
        ])->content('Apply')->attr(['form' => 'discount-frm'])->html(), $template);

        return $template;
    }

    protected function titleTemplate(string $title) : string
    {
        return <<<HTML
            <div class="card-sub-title">
                <h4 class="title">
                $title
                </h4>
            </div>
    HTML;
    }

    protected function isFileexists(string $file) : bool
    {
        if (!file_exists($file)) {
            throw new BaseException('File does not exist!', 1);
        }
        return true;
    }

    protected function media(object $obj) : string
    {
        if (isset($obj->media) && !is_null($obj->media)) {
            $media = unserialize($obj->media);
            if (is_array($media) && count($media) > 0) {
                return str_starts_with($media[0], IMG) ? $media[0] : IMG . $media[0];
            }
        }
        return '';
    }
}