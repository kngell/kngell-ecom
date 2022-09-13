<?php

declare(strict_types=1);

class ClothesHomePagePaths implements PathsInterface
{
    private string $viewPath = VIEW . 'client' . DS . 'brand' . DS . 'clothes' . DS . 'partials' . DS;
    private string $templatePath = APP . 'Display' . DS . 'Brand' . DS . 'Clothes' . DS . 'Templates' . DS;

    public function Paths(): CollectionInterface
    {
        return new Collection(array_merge($this->templatesPath(), $this->viewPath()));
    }

    private function templatesPath() : array
    {
        return [
            'mainClothesPath' => $this->templatePath . 'mainClothesSectionTemplate.php',
            'arrivalsPath' => $this->templatePath . 'arrivalsSectionTemplate.php',
            'arrivalItemPath' => $this->templatePath . 'arrivalItemTemplate.php',
            'featurePath' => $this->templatePath . 'featuresSectionTemplate.php',
            'featuresItemsPath' => $this->templatePath . 'featuresItemsTemplate.php',
            'dressesSuitPath' => $this->templatePath . 'dessesSuitsSectionTemplate.php',
            'dresseSuitItemPath' => $this->templatePath . 'featuresItemsTemplate.php',
            'bestwishesPath' => $this->templatePath . 'bestwishesCollectionTemplate.php',
            'bestWishesItemPath' => $this->templatePath . 'bestwishesItemTemplate.php',
            'shopTemplate' => $this->templatePath . 'shopTemplate.php',
            'shopItemTemplate' => $this->templatePath . 'shopItemTempplate.php',
            'detailsPath' => $this->templatePath . 'detailsTemplate.php',
            'imgGalleryTemplate' => $this->templatePath . 'imgGalleryTemplate.php',
            'relatedProductPath' => $this->templatePath . 'relatedProductTemplate.php',
            'relatedProductItemPath' => $this->templatePath . 'relatedProductItemTemplate.php',
        ];
    }

    private function viewPath() : array
    {
        return [
            'brandPath' => $this->viewPath . '_brand.php',
            'middleSeasonPath' => $this->viewPath . '_middle_season.php',
        ];
    }
}
