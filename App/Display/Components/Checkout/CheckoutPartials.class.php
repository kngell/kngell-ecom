<?php

declare(strict_types=1);
class CheckoutPartials
{
    private string $viewPath = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS;
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'Checkout' . DS . 'Templates' . DS;
    private string $progressPath = 'progress_bar' . DS;
    private string $orderInfosPath = 'order_informations' . DS;
    private string $shippingInfosPath = 'shipping_informations' . DS;
    private string $billingInfosPath = 'billing_informations' . DS;
    private string $paimentPath = 'paiment_informations' . DS;

    public function Paths() : CollectionInterface
    {
        return new Collection(array_merge($this->userInfosPaths(), $this->progressBarPath(), $this->shippingInfosPaths(), $this->billingInfosPaths(), $this->discountPaths(), $this->paiementPaths()));
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
            'deliveryAddressPath' => $this->viewPath . $this->orderInfosPath . '_checkout_delivery_address.php',
            'contactInfosPath' => $this->viewPath . $this->orderInfosPath . '_checkout_contact_infos.php',
            'contactTitlePath' => $this->viewPath . $this->orderInfosPath . '_contact_title.php',
            'cartSummaryPath' => $this->viewPath . $this->orderInfosPath . '_card_summary.php',
            'cartSummaryContentPath' => $this->viewPath . $this->orderInfosPath . '_cart_summary_content.php',
            'cartSummaryTotalPath' => $this->viewPath . $this->orderInfosPath . '_cartSummaryTotal.php',
            'texesPath' => $this->templatePath . 'checkoutTaxTemplate.php',
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
        ];
    }
}