<?php

declare(strict_types=1);

abstract class AbstractModals
{
    use DisplayTraits;
    protected ?CollectionInterface $paths;
    protected ?FormBuilder $frm;

    public function __construct(?FormBuilder $frm, ModalsPaths $paths)
    {
        $this->paths = $paths->Paths();
        $this->frm = $frm;
    }

    protected function AddAdressContent(string $delivery = 'N', string $billing = 'N') : string
    {
        $addAddress = $this->getTemplate('addAddressPath');

        $addAddress = str_replace('{{principale}}', $this->frm->input([
            HiddenType::class => ['name' => 'principale', 'class' => ['principale']],
        ])->noLabel()->noWrapper()->id('principale')->value($delivery)->html(), $addAddress);

        $addAddress = str_replace('{{billing_addr}}', $this->frm->input([
            HiddenType::class => ['name' => 'billing_addr', 'class' => ['billing_addr']],
        ])->noLabel()->noWrapper()->id('billing_addr')->value($billing)->html(), $addAddress);

        $addAddress = str_replace('{{pays}}', $this->frm->input([
            SelectType::class => ['name' => 'pays', 'class' => ['input-box__select', 'select_country']],
        ])->noLabel()->id('pays')->req()->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{address1}}', $this->frm->input([
            TextType::class => ['name' => 'address1'],
        ])->Label('Adresse ligne 1')->id('address1')->req()->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{address2}}', $this->frm->input([
            TextType::class => ['name' => 'address2'],
        ])->Label('Adresse ligne 2')->id('address2')->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{ville}}', $this->frm->input([
            TextType::class => ['name' => 'ville'],
        ])->Label('Ville')->id('ville')->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{region}}', $this->frm->input([
            TextType::class => ['name' => 'region'],
        ])->Label('Région/Etat')->id('region')->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{zipCode}}', $this->frm->input([
            TextType::class => ['name' => 'zip_code'],
        ])->Label('Code Postal')->id('zip_code')->req()->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{u_comment}}', $this->frm->input([
            TextAreaType::class => ['name' => 'u_comment', 'class' => ['input-box__textarea']],
        ])->Label('Commentaires, notes ...')->id('u_comment')->attr(['form' => 'user-ckeckout-frm'])->rows(2)->LabelClass(['input-box__label'])->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{useforBilling}}', $this->frm->input([
            CheckBoxType::class => ['name' => 'use_for_billing'],
        ])->Label('Utiliser cette address pour la facturation')->id('use_for_billing')->class(['checkbox__input'])->spanClass(['checkbox__box'])->LabelClass(['checkbox'])->wrapperClass(['mt-2'])->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{save_for_later}}', $this->frm->input([
            CheckBoxType::class => ['name' => 'save_for_later'],
        ])->Label('Sauvegarder pour la prochaine fois')->id('save_for_later')->class(['checkbox__input'])->spanClass(['checkbox__box'])->LabelClass(['checkbox'])->wrapperClass(['mt-2'])->placeholder(' ')->html(), $addAddress);

        return $addAddress;
    }
}
