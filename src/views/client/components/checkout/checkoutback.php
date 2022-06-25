<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<script src="https://js.stripe.com/v3/"></script>
<meta name="csrftoken" content="<?=$this->token->generate_token(8, 'checkout_page')?>" />
<!-------Costum-------->
<link href="<?= $this->asset('css/custom/client/users/checkout/checkout', 'css') ?? ''?>" rel="stylesheet"
    type="text/css">

<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <div class="container">
        <!-- Progress Bar -->
        <div class="page-content py-5">
            <div class="multistep-frm-wrapper col-12">
                <?=$this->form->globalAttr($frm)->begin()?>
                <!-- Progress bar -->
                <div class="progressbar">
                    <div class="progress" id="progress"></div>
                    <div class="progress-step progress-step-active" data-title="Contact"></div>
                    <div class="progress-step" data-title="Shipping"></div>
                    <div class="progress-step" data-title="Billing"></div>
                    <div class="progress-step" data-title="Payment"></div>
                </div>
                <!-- Steps -->
                <div class="form-step form-step-active" id="order-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <?php require 'partials/_card_summary.php'?>
                            <!-- end card-->
                            <div class="btns-group">
                                <button type="button" class="btn btn-first btn-next"><span> Next</span> <i
                                        class="fas fa-angle-double-right"></i> </button>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body form-wrapper">
                                    <?php if (isset(AuthManager::$currentLoggedInUser) && $this->user_data) :?>
                                    <div class="user-prim-data">
                                        <div class="d-flex mt-2 justify-content-between form-title">
                                            <h4 class="card-sub-title">Information - Contact</h4>
                                            <?php if (!isset(AuthManager::$currentLoggedInUser)) :?>
                                            <div class="account-request">
                                                <span aria-hidden="true">Already have an account?</span>
                                                <a class="text-highlight" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#login-box">Login</a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php require 'partials/_checkout_contact_infos.php'?>
                                        <?php require 'partials/_checkout_delivery_address.php'?>
                                    </div>
                                    <?php endif?>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                    </div>

                </div>
                <div class="form-step" id="shipping-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <?php require 'partials/_card_summary.php'?>
                            <div class="btns-group">
                                <button type="button" class="btn btn-next"><span> Next</span> <i
                                        class="fas fa-angle-double-right"></i> </button>
                                <button type="button" class="btn btn-prev"><span></span> <i
                                        class="fas fa-angle-double-left"></i> Previous </button>

                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body">
                                    <div class="border p-3 mb-3 rounded info-resume">
                                        <table class="table table-borderless">
                                            <tr class="border-bottom contact">
                                                <td class="title">Contact:</td>
                                                <td class="value contact-email">donnie1973@hotmail.com</td>
                                                <td class="link"><a href="#" class="text-highlight"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-email">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom address">
                                                <td class="title">Ship to:</td>
                                                <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                                                    Connecticut(CT),
                                                    06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td class="link"><a href="#" class="text-highlight change-ship__btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-change-address">Change</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Shipping method
                                        </h4>
                                    </div>
                                    <div class="border mb-3 rounded radio-check-group">
                                        <?php if (isset($this->shipping_class) && $this->shipping_class->count() > 0) :?>
                                        <?php foreach ($this->shipping_class->get_results() as $shipping_class) :?>
                                        <?php $form->setModel($shipping_class)->wrapperClass('radio-check__wrapper')->fieldCommonclass(['fieldclass' => 'radio__input', 'labelClass' => 'radio']) ?>
                                        <?php if ($shipping_class->status == 'on'):?>
                                        <?php $default = $shipping_class->default_shipping_class == 1 ? true : false ?>
                                        <div class="radio-check">
                                            <?= $form->radio('sh_name')->id('sh_name')->radioType()->spanClass('radio__radio')->textClass('radio__text')->labelDescr($shipping_class->sh_descr)->checked($default)->price($shipping_class->price)?>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row-->

                </div>
                <div class="form-step" id="billing-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <?php require 'partials/_card_summary.php'?>
                            <div class="btns-group">
                                <button type="button" class="btn btn-next"><span> Next</span> <i
                                        class="fas fa-angle-double-right"></i> </button>
                                <button type="button" class="btn btn-prev"><span></span> <i
                                        class="fas fa-angle-double-left"></i> Previous </button>

                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body">
                                    <div class="border p-3 mb-3 rounded info-resume">
                                        <table class="table table-borderless">
                                            <tr class="border-bottom contact">
                                                <td>Contact:</td>
                                                <td class="value contact-email">donnie1973@hotmail.com</td>
                                                <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-email">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom address">
                                                <td class="title">Ship to:</td>
                                                <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                                                    Connecticut(CT), 06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td><a href="#" class="text-highlight change-ship__btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-change-address">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom method">
                                                <td class="title">Shipping Method</td>
                                                <td class="shipping_method"> <span class="method_title">FedEx Ground
                                                    </span> &nbsp;<span class="price">$8.73</span> </td>
                                                <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-shipping">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom bill-address-ckeck" style="display: none;">
                                                <td class="title">bill to:</td>
                                                <td class="value bill-to-address">3363 Cook Hill Road, Wallingford,
                                                    Connecticut(CT), 06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td><a href="#" class="text-highlight change-bill__btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-change-address">Change</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Billing address
                                        </h4>
                                    </div>
                                    <p class="infos-transaction">Select the address that matches your card or
                                        payment
                                        method.</p>
                                    <div id="order-billing-address" class="border mb-3 rounded radio-check-group">
                                        <div class="billing-address ">
                                            <div class="radio-check billing-address-header">
                                                <?= $form->radio('prefred_billing_addr')->radioType()->id('checkout-billing-address-id-1')->value('1')->spanClass('radio__radio')->textClass('radio__text')->Label('Same as shipping address')?>
                                            </div>
                                            <!-- end billing-address-header -->
                                        </div>
                                        <!-- end billing-address -->
                                        <div class="billing-address">
                                            <div class="radio-check billing-address-header">
                                                <?= $form->radio('prefred_billing_addr')->id('checkout-billing-address-id-2')->radioType()->value('2')->spanClass('radio__radio')->textClass('radio__text')->Label('Use a different billing address')?>
                                            </div>
                                        </div>
                                        <!-- end billing-address -->
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </div>
                <div class="form-step" id="payment-information">
                    <div class="row flex-lg-row-reverse">
                        <div class="col-lg-4 order-summary">
                            <?php require 'partials/_card_summary.php'?>
                            <div class="btns-group">
                                <button type="button" class="btn" id="pay-now"><span> Pay Now</span> <i
                                        class="fas fa-angle-double-right"></i> </button>
                                <button type="button" class="btn btn-prev"><span></span> <i
                                        class="fas fa-angle-double-left"></i> Previous </button>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-8 order-details">
                            <div class="card">
                                <div class="card-body">
                                    <div class="border p-3 mb-3 rounded info-resume">
                                        <table class="table table-borderless">
                                            <tr class="border-bottom contact">
                                                <td>Contact:</td>
                                                <td class="value contact-email">donnie1973@hotmail.com</td>
                                                <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-email">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom address">
                                                <td class="title">Ship to:</td>
                                                <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                                                    Connecticut(CT), 06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td><a href="#" class="text-highlight change-ship__btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-change-address">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom method">
                                                <td class="title">Shipping Method:</td>
                                                <td class="shipping_method"> <span class="method_title">FedEx Ground
                                                    </span> &nbsp;<span class="price">$8.73</span> </td>
                                                <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-shipping">Change</a></td>
                                            </tr>
                                            <tr class="border-bottom facturation">
                                                <td class="title">Bill to:</td>
                                                <td class="value bill-to-address">3363 Cook Hill Road, Wallingford,
                                                    Connecticut(CT), 06492,
                                                    Wallingford CT
                                                    06492, United
                                                    States</td>
                                                <td><a href="#" class="text-highlight change-bill__btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-box-change-address">Change</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card-sub-title">
                                        <h4 class="title">
                                            Payement
                                        </h4>
                                    </div>
                                    <p class="infos-transaction">All transactions are secure and encrypted.</p>
                                    <div id="order-payment" class="border mb-3 rounded radio-check-group">
                                        <?php if (isset($this->pmt_getaway) && $this->pmt_getaway->count() > 0) :?>
                                        <?php foreach ($this->pmt_getaway->get_results() as $pmt_getaway) :?>
                                        <?php if ($pmt_getaway->status == 'on'):?>
                                        <?php $form->setModel($pmt_getaway)->wrapperClass('radio-check__wrapper')->fieldCommonclass(['fieldclass' => 'radio__input', 'labelClass' => 'radio']); ?>
                                        <div class="payment-gateway">
                                            <div class="radio-check payment-gateway-header">
                                                <?php $checked = ($pmt_getaway->pm_name == 'Credit Card') ? true : false; ?>
                                                <?= $form->radio('pm_name')->id('pm_name')->radioType()->value(strval($pmt_getaway->pmID))->spanClass('radio__radio')->textClass('radio__text')->label($pmt_getaway->pm_name)->checked($checked)?>

                                                <?php if ($pmt_getaway->pm_name == 'Credit Card') :?>
                                                <div class="brand-icons">
                                                    <span><a href="#" class="text-highlight">Change</a></span>
                                                    <span class="payment-icon payment-icon-visa">
                                                    </span>
                                                    <span class="payment-icon payment-icon-master">
                                                    </span>
                                                    <span class="payment-icon payment-icon-american-express">
                                                    </span>
                                                    <span class="payment-icon payment-icon-discover">
                                                    </span>
                                                </div>
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                    <!-- end order-payment -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </div>
                <div class="modal fade" role="dialog" id="payment-box">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Payment amount: &nbsp;<span
                                        class="price"><?=$this->user_cart[2][1]?></span></h5>
                                <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div id="pmt_ErrMsg"></div>
                                <?=$this->credit_cardForm?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?=$this->form->end()?>
        </div>
    </div>
    <section id="modal">

        <!----------Change Email Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-email">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Change Email Address</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="change-email-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'change-email-frm')); ?>
                            <div id="alertErr"></div>
                            <div class="mb-3">
                                <input type="text" name="email" id="chg-email" class="form-control "
                                    placeholder="New Email Address" aria-describedby="chg-email-feedback">
                                <div class="invalid-feedback" id="brands-feedback"></div>
                            </div>
                            <div class="mb-3 justify-content-between">
                                <input type="submit" name="submitBtn" id="submitBtnEmail" value="Submit" class="button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----------Change Address Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-change-address">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Change Address</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="change-address-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'change-address-frm')); ?>
                            <div id="alertErr"></div>
                            <?=$this->address_book?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!----------Add New Address Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-add-address">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Add Address</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="add-address-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'add-address-frm')); ?>
                            <div id="alertErr"></div>
                            <div class="mb-3">
                                <input type="text" name="address1" id="chg-address1" class="form-control "
                                    placeholder="New address line 1" aria-describedby="chg-address1-feedback">
                                <div class="invalid-feedback" id="chg-address1-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="address2" id="chg-address2" class="form-control "
                                    placeholder="New Address line 2" aria-describedby="chg-address2-feedback">
                                <div class="invalid-feedback" id="chg-address2-feedback"></div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" name="ville" id="chg-ville" class="form-control "
                                        placeholder="New City" aria-describedby="chg-ville-feedback">
                                    <div class="invalid-feedback" id="chg-ville-feedback"></div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="text" name="zip_code" id="chg-zip_code" class="form-control "
                                        placeholder="New Zip_code" aria-describedby="chg-zip_code-feedback">
                                    <div class="invalid-feedback" id="chg-zip_code-feedback"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="region" id="chg-region" class="form-control "
                                    placeholder="New Region" aria-describedby="chg-region-feedback">
                                <div class="invalid-feedback" id="chg-region-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <select type="text" name="pays" id="chg-pays" class="form-control" style="width: 100%;">
                                    <option value=""></option>
                                </select>
                                <div class="invalid-feedback" id="brands-feedback"></div>
                            </div>
                            <div class="mb-3 justify-content-between">
                                <input type="submit" name="submitBtn" id="submitBtnAddress" value="Submit"
                                    class="button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!----------Add New Shipping Modal-------->
        <div class="modal fade" role="dialog" id="modal-box-shipping">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Mode de livraison</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="shipping-select-frm" class="px-3 needs-validation" novalidate
                            enctype="multipart/form-data">
                            <?= FH::csrfInput('csrftoken', $this->token->generate_token(8, 'shipping-select-frm')); ?>
                            <div id="alertErr"></div>
                            <div class="mb-3">
                                <select type="text" name="shipping_class_change" id="shipping_class_change"
                                    class="form-control" style="width: 100%;">
                                    <option value=""></option>
                                </select>
                                <div class="invalid-feedback" id="brands-feedback"></div>
                            </div>
                            <div class="mb-3 justify-content-between">
                                <input type="submit" name="submitBtn" id="submitBtnShipping" value="Submit"
                                    class="button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Content -->
        <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
    </section>
    <!-- Fin Content -->
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/users/checkout/checkout', 'js') ?? ''?>">
</script>
<?php $this->end();