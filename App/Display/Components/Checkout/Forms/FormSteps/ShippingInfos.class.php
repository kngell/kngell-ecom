<?php

declare(strict_types=1);

class ShippingInfos extends AbstractCheckoutformSteps
{
    private string $title = 'Shipping Method';
    private MoneyManager $money;

    public function __construct(protected ?object $frm, private ?CartSummary $summary, private ?CollectionInterface $obj, protected ?CollectionInterface $paths, protected ?ButtonsGroup $btns)
    {
        $this->money = MoneyManager::getInstance();
    }

    public function display() : string
    {
        $mainTemplate = $this->paths->offsetGet('mainShippingPath');
        $shippingData = $this->paths->offsetGet('shippingData');
        if ((!file_exists($mainTemplate) || !file_exists($shippingData))) {
            throw new BaseException('Files Not found!', 1);
        }
        return $this->outputTemplate(file_get_contents($mainTemplate), file_get_contents($shippingData), $this->obj);
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '', ?Object $obj = null) : string
    {
        $temp = '';
        if (!is_null($obj) && $obj->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
            $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
            $temp = str_replace('{{data}}', $dataTemplate, $temp);
            $temp = str_replace('{{title}}', $this->titleTemplate($this->title), $temp);
            $temp = str_replace('{{form_shipping_method}}', $this->shippingform($obj), $temp);
            $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);
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
                $template = str_replace('{{price}}', strval($this->money->getFormatedAmount(strval($shippingClass->price))) ?? '', $template);
                $html .= $template;
                $i++;
            }
        }
        return $html;
    }
}