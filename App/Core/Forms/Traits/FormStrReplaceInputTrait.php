<?php

declare(strict_types=1);

trait FormStrReplaceInputTrait
{
    public function hiddenInputs(array $args = []) : string
    {
        $hiddenHtml = '';
        if (!empty($args)) {
            foreach ($args as $name => $value) {
                $arg = $this->print->hidden($name, $value, [$name]);
                $hiddenHtml .= $this->input($arg)->noLabel()->noWrapper()->html();
            }
        }

        return $hiddenHtml;
    }

    public function replaceText(?string $template = null, ?string $stringToreplace = null, array $args = []) : string
    {
        if (!is_null($stringToreplace) && !is_null($template)) {
            $str = str_replace($stringToreplace, $this->input([
                TextType::class => $args,
            ])->html(), $template);

            return $str;
        }

        return '';
    }
}
