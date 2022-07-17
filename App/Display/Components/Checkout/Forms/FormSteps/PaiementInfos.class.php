<?php

declare(strict_types=1);

class PaiementInfos extends AbstractCheckoutformSteps implements CheckoutFormStepInterface
{
    private string $title = 'Paiement Informations';

    public function __construct(protected ?object $frm, protected ?CartSummary $summary, protected ?object $obj, protected ?CollectionInterface $paths = null, protected ?ButtonsGroup $btns = null)
    {
    }

    public function display() : string
    {
        $mainTemplate = $this->paths->offsetGet('mainBillingPath');
        $data = $this->paths->offsetGet('paiementData');
        if ((!file_exists($mainTemplate) || !file_exists($data))) {
            throw new BaseException('Files Not found!', 1);
        }
        return $this->outputTemplate(file_get_contents($mainTemplate), file_get_contents($data));
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '') : string
    {
        $temp = '';
        $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
        $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
        $temp = str_replace('{{data}}', $dataTemplate, $temp);
        $temp = str_replace('{{title}}', $this->titleTemplate($this->title), $temp);
        $temp = str_replace('{{paiementForm}}', $this->form(), $temp);
        $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);
        return $temp;
    }

    private function form() : string
    {
        $i = 0;
        $html = '';
        $temp = $this->paths->offsetGet('paiementFormPath');
        $ccIcon = $this->paths->offsetGet('creditCardIconsPath');
        $this->isFileexists($temp);
        $this->isFileexists($ccIcon);
        $temp = file_get_contents($temp);
        $ccIcon = file_get_contents($ccIcon);
        if ($this->obj->count() > 0) {
            foreach ($this->obj->all() as $mode) {
                if ($mode->status == 'on') {
                    $default = $mode->default == 1 ? true : false;
                    $template = str_replace('{{paiement_mode}}', $this->frm->input([
                        RadioType::class => ['name' => 'pm_name', 'class' => ['radio__input', 'me-2']],
                    ])->id('pm_name' . $i)
                        ->spanClass(['radio__radio'])
                        ->textClass(['radio__text'])
                        ->label($mode->pm_name)
                        ->checked($i == 0 ? $default : false)
                        ->wrapperClass(['radio-check__wrapper'])
                        ->labelClass(['radio'])
                        ->html(), $temp);
                    $template = str_replace('{{CreditCarIcons}}', $mode->pm_name == 'Credit Card' ? $ccIcon : '', $template);
                    $html .= $template;
                    $i++;
                }
            }
        }
        return $html;
    }
}