<?php

declare(strict_types=1);

use Brick\Money\Money;

abstract class AbstractShoppingCartPage
{
    use DisplayTraits;
    use CartSummaryTrait;

    protected ?CollectionInterface $cartItems;
    protected ?CollectionInterface $paths;
    protected ?MoneyManager $money;
    protected ?FormBuilder $frm;
    protected array $taxesProducts = [];
    protected ?Money $HT = null;
    protected ?string $TTC = null;
    protected string $wishlistStyle;

    public function __construct(?CollectionInterface $cartItems = null, ?ShoppingCartPaths $paths = null, ?MoneyManager $money = null, ?FormBuilder $frm = null)
    {
        $this->cartItems = $cartItems;
        $this->paths = $paths->Paths();
        $this->money = $money;
        $this->frm = $frm;
        $this->wishlistStyle = 'style="display:none"';
    }

    protected function shoppingCartSubtotal() : string
    {
        $this->HT = $this->totalHT($this->cartItems);
        $template = $this->getTemplate('shoppingCartsubtotalPath');
        $taxTemplate = $this->getTemplate('cartTaxTemplate');
        $finalTaxes = $this->calcTaxes($this->taxesProducts);
        list($taxeHtml, $totalTaxes) = $this->taxesHtmlAndtotal($finalTaxes, $taxTemplate);
        $template = str_replace('{{nb_items}}', strval($this->cartItems->filter(function ($item) {
            return $item->cart_type == 'cart';
        })->count()), $template);
        $template = str_replace('{{totalHT}}', $this->HT->formatTo('fr_FR'), $template);
        $template = str_replace('{{taxResumeHtml}}', $taxeHtml, $template);
        $this->TTC = $this->HT->plus($totalTaxes)->formatTo('fr_FR');
        $template = str_replace('{{totalTTC}}', $this->TTC ?? '', $template);
        $template = str_replace('{{proceedTobuyform}}', $this->proceedToBuyForm(), $template);

        return $template;
    }

    protected function shoppingCartItems() : string
    {
        $template = $this->getTemplate('shoppingItemCollectionPath');
        if ($this->cartItems->count() > 0) {
            /** @var CollectionInterface */
            $cartItems = $this->cartItems->filter(function ($item) {
                return $item->cart_type == 'cart';
            });
            if ($cartItems->count() > 0) {
                return $this->itemsHtml($cartItems, $template, 'shoppingItems', 'shoppingItemPath');
            }
        }

        return str_replace('{{shoppingItems}}', $this->getTemplate('emptycartPath'), $template);
    }

    protected function whishlistItems() : string
    {
        $template = $this->getTemplate('whishlistCollectionPath');
        if ($this->cartItems->count() > 0) {
            /** @var CollectionInterface */
            $whishlist = $this->cartItems->filter(function ($item) {
                return $item->cart_type == 'wishlist';
            });
            $this->wishlistStyle = $whishlist->count() > 0 ? 'style="display:block"' : 'style="display:none"';

            return $this->itemsHtml($whishlist, $template, 'whishlist_item', 'whishlistItemPath');
        }

        return $this->wishlistStyle = 'style="display:none"';
    }

    protected function itemsHtml(CollectionInterface $collectionItems, string $template, string $replace, string $templatePath) : string
    {
        if ($collectionItems->count() > 0) {
            $ItemsHtml = '';
            $itemHtml = $this->getTemplate($templatePath);
            foreach ($collectionItems->all() as $item) {
                if ($item->cart_type == 'cart') {
                    $ItemsHtml .= $this->shoppingItemHtml($item, $itemHtml);
                } elseif ($item->cart_type == 'wishlist') {
                    $ItemsHtml .= $this->whishlistItemHtml($item, $itemHtml);
                }
            }

            return str_replace('{{' . $replace . '}}', $ItemsHtml, $template);
        }

        return '';
    }

    private function proceedToBuyForm() : string
    {
        $form = $this->frm->form([
            'action' => 'proceed_to_checkout',
            'class' => ['buy-frm'],
            'id' => 'buy-frm',
        ]);
        $template = $this->getTemplate('proceedTobuyFormPath');
        $template = str_replace('{{form_begin}}', $form->begin(), $template);
        $template = str_replace('{{proceedToBuyBtn}}', $form->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['button', 'buy-btn']],
        ])->content('Proceed to checkout')->noWrapper()->html(), $template);
        $template = str_replace('{{form_end}}', $this->frm->end(), $template);

        return $template;
    }

    private function shoppingItemHtml(?object $item = null, ?string $template = null) : string
    {
        $temp = '';
        $HT = $item->regular_price * $item->item_qty;
        $this->taxesProducts[] = $this->filterTaxe($HT, $item, $this->getAllTaxes($this->cartItems), $item->item_qty);
        if (!is_null($item) && !is_null($template)) {
            $temp = str_replace('{{image}}', $this->media($item), $template);
            $temp = str_replace('{{title}}', $item->title, $temp);
            $temp = str_replace('{{categorie}}', $item->categorie, $temp);
            $temp = str_replace('{{itemQtyForm}}', $this->shoppingItemQtyForm($item), $temp);
            $temp = str_replace('{{itemDelItemFrom}}', $this->shoppingItemDelForm($item, 'cart'), $temp);
            $temp = str_replace('{{price}}', $this->money->getFormatedAmount(strval($item->regular_price * $item->item_qty)), $temp);
        }

        return $temp;
    }

    private function whishlistItemHtml(?object $item = null, ?string $template = null) : string
    {
        $temp = '';
        $HT = $item->regular_price * $item->item_qty;
        $this->taxesProducts[] = $this->filterTaxe($HT, $item, $this->getAllTaxes($this->cartItems), $item->item_qty);
        if (!is_null($item) && !is_null($template)) {
            $temp = str_replace('{{image}}', $this->media($item), $template);
            $temp = str_replace('{{title}}', $item->title, $temp);
            $temp = str_replace('{{categorie}}', $item->categorie, $temp);
            $temp = str_replace('{{whishlist_del_frm}}', $this->shoppingItemDelForm($item, 'wishlist'), $temp);
            $temp = str_replace('{{price}}', $this->money->getFormatedAmount(strval($item->regular_price * $item->item_qty)), $temp);
        }

        return $temp;
    }

    private function shoppingItemQtyForm(?object $item = null) : string
    {
        $form = $this->frm->form([
            'action' => '',
            'class' => ['form_qty'],
        ])->setCsrfKey('form_qty');

        $template = $this->getTemplate('shoppingQtyformPath');

        $template = str_replace('{{form_begin}}', $form->begin(), $template);

        $template = str_replace('{{buttonUp}}', $form->input([
            ButtonType::class => ['type' => 'button', 'class' => ['qty-up', 'border', 'bg-light']],
        ])->content('<span class="qty-up-icon"></span>')->noWrapper()->html(), $template);

        $template = str_replace('{{input}}', $form->input([
            TextType::class => ['name' => 'item_qty', 'class' => ['qty_input', 'px-2', 'bg-light']],
        ])->noLabel()->noWrapper()->value($item->item_qty)->placeholder('1')->attr(['min' => '1'])->html(), $template);

        $template = str_replace('{{item}}', $form->input([
            HiddenType::class => ['name' => 'item_id', 'class' => []],
        ])->noLabel()->noWrapper()->value($item->item_id)->html(), $template);

        $template = str_replace('{{buttonDown}}', $form->input([
            ButtonType::class => ['type' => 'button', 'class' => ['qty-down', 'border', 'bg-light']],
        ])->content('<span class="qty-down-icon"></span>')->noWrapper()->html(), $template);

        $template = str_replace('{{form_end}}', $this->frm->end(), $template);

        return $template;
    }

    private function shoppingItemDelForm(?object $item, ?string $type) : string
    {
        if ($type == 'cart') {
            $btn = 'Sauvegarder';
            $btn_class = ['btn', 'font-baloo', 'px-3', 'border-right', 'deleteBtn'];
        } elseif ($type == 'wishlist') {
            $btn = 'Add to cart';
            $btn_class = ['btn', 'font-baloo', 'pl-0', 'pr-3', 'border-right', 'deleteBtn'];
        }

        $form = $this->frm->form([
            'action' => '#',
            'class' => ['delete-cart-item-frm'],
            'id' => 'delete-cart-item-frm' . $item->pdt_id ?? 1,
        ]);
        $template = $this->getTemplate('shoppingDelFormPath');
        $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);

        $template = str_replace('{{input}}', $form->input([
            HiddenType::class => ['name' => 'item_id'],
        ])->noLabel()->noWrapper()->value($item->pdt_id)->html(), $template);

        $template = str_replace('{{buttonSupprimer}}', $form->input([
            ButtonType::class => ['type' => 'submit', 'class' => $btn_class],
        ])->content('Supprimer')->noWrapper()->html(), $template);

        $template = str_replace('{{buttonSauvegarder}}', $form->input([
            ButtonType::class => ['type' => 'button', 'class' => ['btn', 'save-add']],
        ])->content($btn)->noWrapper()->html(), $template);

        $template = str_replace('{{form_end}}', $this->frm->end(), $template);

        return $template;
    }
}
