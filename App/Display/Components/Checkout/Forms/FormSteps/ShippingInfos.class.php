<?php

declare(strict_types=1);

class ShippingInfos extends AbstractCheckout
{
    public function __construct(protected ?object $frm, private ?string $summary, private ?CollectionInterface $obj, protected ?CollectionInterface $paths, private ?ButtonsGroup $btns)
    {
    }

    public function display() : string
    {
        $mainTemplate = $this->paths->offsetGet('mainShippingPath');
        $shippingData = $this->paths->offsetGet('shippingData');
        if ((!file_exists($mainTemplate) || !file_exists($shippingData))) {
            throw new BaseException('Files Not found!', 1);
        }
        return $this->outputShippingInfosTemplate(file_get_contents($mainTemplate), file_get_contents($shippingData), $this->obj);
    }

    private function outputShippingInfosTemplate(string $template = '', string $dataTemplate = '', ?Object $obj = null) : string
    {
        $temp = '';
        if (!is_null($obj) && $obj->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->summary, $template);
            $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
            $temp = str_replace('{{shipping_data}}', $dataTemplate, $temp);
            $temp = str_replace('{{shippingTitle}}', $this->titleTemplate('Shipping Method'), $temp);
            $temp = str_replace('{{form_shipping_method}}', $this->shippingform($obj), $temp);
            $temp = str_replace('{{buttonsRight}}', $this->btns->buttonsGroup('next'), $temp);
            $temp = str_replace('{{buttonsLeft}}', $this->btns->buttonsGroup('prev'), $temp);
        }
        return $temp;
    }

    private function shippingform(?object $obj) : string
    {
        $temp = $this->paths->offsetGet('shippingMethod');
        $this->isFileexists($temp);
        $temp = file_get_contents($temp);
        $html = '';
        $i = 0;
        foreach ($obj->all() as $shippingClass) {
            if ($shippingClass->status == 'on') {
                $default = $shippingClass->default_shipping_class == 1 ? true : false;
                $template = str_replace('{{shipping_method}}', $this->frm->input([
                    RadioType::class => ['name' => 'sh_name', 'class' => ['radio__input', 'me-2']],
                ])->id('sh_name' . $i)
                    ->spanClass(['radio__radio'])
                    ->textClass(['radio__text'])
                    ->label($shippingClass->sh_name)
                    ->labelDescr($shippingClass->sh_descr)
                    ->checked($i == 0 ? $default : false)
                    ->wrapperClass(['radio-check__wrapper'])
                    ->labelClass(['radio'])
                    ->templatePath($this->paths->offsetGet('shippingRadioInpuut'))
                    ->html(), $temp);
                $template = str_replace('{{price}}', $shippingClass->price, $template);
                $html .= $template;
                $i++;
            }
        }
        return $html;
    }
}