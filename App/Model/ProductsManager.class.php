<?php

declare(strict_types=1);
class ProductsManager extends Model
{
    protected $_colID = 'pdt_id';
    protected $_table = 'products';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function getProducts(int $brand) : CollectionInterface
    {
        $this->table()
            ->leftJoin('product_categorie', ['pdt_id', 'cat_id'])
            ->leftJoin('categories', ['categorie'])
            ->leftJoin('brand', ['br_name'])
            ->on(['pdt_id',  'pdt_id'], ['cat_id', 'cat_id'], ['br_id', 'br_id'])
            ->where(['br_id' => [$brand, 'categories']])
            ->groupBy(['pdt_id DESC' => 'product_categorie'])
            ->return('object');

        return new Collection($this->getAll()->get_results());
    }

    public function getSingleProduct(string $slug) : ?object
    {
        $this->table()
            ->leftJoin('product_categorie', ['pdt_id', 'cat_id'])
            ->leftJoin('categories', ['categorie'])
            ->leftJoin('brand', ['br_name'])
            ->on(['pdt_id',  'pdt_id'], ['cat_id', 'cat_id'], ['br_id', 'br_id'])
            ->where(['slug' => [$slug, 'products']])
            ->groupBy(['pdt_id DESC' => 'products'])
            ->return('object');
        $pdt = $this->getAll();
        if ($pdt->count() === 1) {
            return current($pdt->get_results());
        }

        return null;
    }
}
