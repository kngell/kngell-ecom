<?php

declare(strict_types=1);
class SettingsManager extends Model
{
    protected $_colID = 'setID';
    protected $_table = 'settings';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function getSettings() : CollectionInterface
    {
        $this->table(null, ['setting_key', 'value'])->return('object');
        $settings = new Collection();
        foreach ($this->getAll()->get_results() as $setting) {
            $settings->offsetSet($setting->setting_key, $setting->value);
        }

        return $settings;
    }
}
