<?php

declare(strict_types=1);

class AddressBookManager extends Model
{
    protected $_colID = 'ab_id';
    protected $_table = 'address_book';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function getUserAddress() : CollectionInterface
    {
        if (AuthManager::isUserLoggedIn()) {
            $this->table()->where(['tbl' => 'users', 'rel_id' => $this->session->get(CURRENT_USER_SESSION_NAME)['id']])->return('object');
            $add = $this->getAll()->get_results();
            foreach ($add as $address) {
                $address->pays = $this->container(CountriesManager::class)->country($address->pays);
                // code...
            }

            return new Collection($add);
        }

        return new Collection([]);
    }

    public function getSingleAddress() : ?self
    {
        $singleAddress = $this->getDetails();
        if ($singleAddress->count() === 1) {
            $singleAddress = $singleAddress->get_results();
            $singleAddress->assign((array) $singleAddress);
            //$singleAddress->pays = $this->container(CountriesManager::class)->country($singleAddress->pays);
            return $singleAddress;
        }

        return null;
    }

    public function saveAddress(?string $tbl = null, int $id = -1) : ?self
    {
        /** @var AddressBookEntity */
        $en = $this->getEntity();
        if (!$en->isInitialized('ab_id')) {
            $tbl = $en->isInitialized('tbl') ? $en->getTbl() : $tbl;
            $id = $en->isInitialized('rel_id') ? $en->getRelId() : $id;
            if ($en->getPrincipale() == 'Y') {
                $data = $en->getInitializedAttributes(true);
                $r = $this->updateAddressPrincipale($id);

                return $r->assign(array_merge($data, ['tbl' => $tbl, 'rel_id' => $id]))->save();
            }

            return $this->assign(['tbl' => $tbl, 'rel_id' => $id])->save();
        }

        return parent::save();
    }

    protected function updateAddressPrincipale(int $id) : self
    {
        $this->table()->where(['tbl' => 'users', 'rel_id' => $id, 'principale' => 'Y'])->return('class');
        $addrPrincipale = $this->getAll();
        if ($addrPrincipale->count() === 1) {
            $addrPrincipale = $addrPrincipale->assign((array) current($addrPrincipale->get_results()));
            $addrPrincipale->getEntity()->{$addrPrincipale->getEntity()->getSetter('principale')}('N');
            $addrPrincipale->getQueryParams()->reset();

            return current($addrPrincipale->save()->get_results());
        }

        return $addrPrincipale;
    }
}
