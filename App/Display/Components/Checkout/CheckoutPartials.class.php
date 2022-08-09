<?php

declare(strict_types=1);
class CheckoutPartials
{
    private string $viewPath = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS;
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'Checkout' . DS . 'Templates' . DS;
    private string $progressPath = 'progress_bar' . DS;
    private string $orderInfosPath = 'user_informations' . DS;
    private string $shippingInfosPath = 'shipping_informations' . DS;
    private string $billingInfosPath = 'billing_informations' . DS;
    private string $paimentPath = 'paiment_informations' . DS;
    private string $modalPath = 'extras_sections' . DS . 'modals' . DS;
    private string $buttonPath = 'buttons_group' . DS;
    private string $cartSummaryPath = 'cart_summary' . DS;

    public function Paths() : CollectionInterface
    {
        return new Collection(array_merge($this->userInfosPaths(), $this->progressBarPath(), $this->shippingInfosPaths(), $this->billingInfosPaths(), $this->discountPaths(), $this->paiementPaths(), $this->buttonPath(), $this->cartSummaryPath(), $this->modalsPaths(), $this->formsPath()));
    }

    private function cartSummaryPath() : array
    {
        return [
            'cartSummaryPath' => $this->viewPath . $this->cartSummaryPath . '_card_summary.php',
            'cartSummaryContentPath' => $this->viewPath . $this->cartSummaryPath . '_cart_summary_data.php',
            'texesPath' => $this->templatePath . 'checkoutTaxTemplate.php',
            'cartSummaryTotalPath' => $this->viewPath . $this->cartSummaryPath . '_cartSummaryTotal.php',
            'totalShippingPath' => $this->templatePath . 'totalShippingTemplate.php',
        ];
    }

    private function progressBarPath() : array
    {
        return [
            'progressBarPath' => $this->viewPath . $this->progressPath . '_progress_bar.php',
        ];
    }

    private function userInfosPaths() : array
    {
        return [
            'mainUserTemplate' => $this->viewPath . $this->orderInfosPath . '_chk_user_info.php',
            'userDataPath' => $this->viewPath . $this->orderInfosPath . '_user_data.php',
            'addAddressPath' => $this->viewPath . $this->orderInfosPath . '_checkout_add_address.php',
            'contactInfosPath' => $this->templatePath . 'userContactInfosTemplate.php',
            'contactTitlePath' => $this->viewPath . $this->orderInfosPath . '_contact_title.php',
        ];
    }

    private function shippingInfosPaths() : array
    {
        return [
            'mainShippingPath' => $this->viewPath . $this->shippingInfosPath . '_shipping_infos.php',
            'shippingData' => $this->viewPath . $this->shippingInfosPath . '_shipping_data.php',
            'shippingMethod' => $this->viewPath . $this->shippingInfosPath . '_shipping_method.php',
            'shippingRadioInpuut' => $this->templatePath . 'shippingRadioTemplate.php',
        ];
    }

    private function billingInfosPaths() : array
    {
        return [
            'mainBillingPath' => $this->viewPath . $this->billingInfosPath . '_billing_infos.php',
            'billingData' => $this->viewPath . $this->billingInfosPath . '_billing_data.php',
            'billingFormPath' => $this->templatePath . 'billingFormTemplate.php',
        ];
    }

    private function discountPaths() : array
    {
        return [
            'mainDiscountPath' => $this->templatePath . 'discountFormTemplate.php',
        ];
    }

    private function paiementPaths() : array
    {
        return [
            'mainPaiementPath' => $this->viewPath . $this->paimentPath . '_paiment_infos.php',
            'paiementData' => $this->viewPath . $this->paimentPath . '_paiement_data.php',
            'paiementFormPath' => $this->templatePath . 'paiementFormTemplate.php',
            'creditCardIconsPath' => $this->templatePath . 'paiementCcIconTemplate.php',
            'creditCardTemplatePath' => $this->templatePath . 'creditCardformTemplate.php',
        ];
    }

    private function modalsPaths() : array
    {
        return [
            'addAddressModalPath' => $this->templatePath . 'addAdressModal.php',
            'changeEmailModalPath' => $this->templatePath . 'changeEmailTemplate.php',
            'changeShippingModalPath' => $this->templatePath . 'changeShippingModeTemplate.php',
            'userAddressModalPath' => $this->templatePath . 'userAddressModalTemplate.php',
        ];
    }

    private function buttonPath() : array
    {
        return [
            'buttonGroupPath' => $this->viewPath . $this->buttonPath . '_button_group.php',
        ];
    }

    private function formsPath() : array
    {
        return [
            'changeEmailformPath' => $this->templatePath . 'changeEmailFormTemplate.php',
            'changeShippingModeformPath' => $this->templatePath . 'changeShippingModeFormTemplate.php',
            'checkoutFormTemplatePath' => $this->templatePath . 'checkoutFormTemplate.php',
            'creditCardModalPath' => $this->templatePath . 'creditCardFormModal.php',
        ];
    }
}