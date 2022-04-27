<?php

namespace Appwrite\Repository;

use Utopia\Config\Config;
use Utopia\Database\Document;
use Utopia\Locale\Locale;
use MaxMind\Db\Reader;

class LocaleRepository
{
    private Locale $locale;
    private Reader $geodb;

    public function __construct($locale, $geodb)
    {
        $this->locale = $locale;
        $this->geodb = $geodb;
    }

    /**
     * @throws \Exception
     */
    public function get(#[RequestMethod('getIp')] callable $getIp): array
    {
        $eu = Config::getParam('locale-eu');
        $currencies = Config::getParam('locale-currencies');
        $ip = $getIp();
        $currency = null;

        $output = [];
        $output['ip'] = $ip;

        $record = $this->geodb->get($ip);

        if ($record) {
            $output['countryCode'] = $record['country']['iso_code'];
            $output['country'] = $this->locale->getText('countries.' . strtolower($record['country']['iso_code']), $this->locale->getText('locale.country.unknown'));
            $output['continent'] = $this->locale->getText('continents.' . strtolower($record['continent']['code']), $this->locale->getText('locale.country.unknown'));
            $output['continent'] = (isset($continents[$record['continent']['code']])) ? $continents[$record['continent']['code']] : $this->locale->getText('locale.country.unknown');
            $output['continentCode'] = $record['continent']['code'];
            $output['eu'] = (\in_array($record['country']['iso_code'], $eu)) ? true : false;

            foreach ($currencies as $code => $element) {
                if (isset($element['locations']) && isset($element['code']) && \in_array($record['country']['iso_code'], $element['locations'])) {
                    $currency = $element['code'];
                }
            }

            $output['currency'] = $currency;
        } else {
            $output['countryCode'] = '--';
            $output['country'] = $this->locale->getText('locale.country.unknown');
            $output['continent'] = $this->locale->getText('locale.country.unknown');
            $output['continentCode'] = '--';
            $output['eu'] = false;
            $output['currency'] = $currency;
        }

        return $output;
    }

    /**
     * @throws \Exception
     */
    public function getCountries(): array
    {
        $list = Config::getParam('locale-countries');

        /* @var $list array */
        $output = [];

        foreach ($list as $value) {
            $output[] = new Document([
                'name' => $this->locale->getText('countries.' . strtolower($value)),
                'code' => $value,
            ]);
        }

        usort($output, function ($a, $b) {
            return strcmp($a->getAttribute('name'), $b->getAttribute('name'));
        });

        return $output;
    }

    /**
     * @throws \Exception
     */
    public function getCountriesEU(): array
    {
        $eu = Config::getParam('locale-eu');
        $output = [];

        foreach ($eu as $code) {
            if ($this->locale->getText('countries.' . strtolower($code), false) !== false) {
                $output[] = new Document([
                    'name' => $this->locale->getText('countries.' . strtolower($code)),
                    'code' => $code,
                ]);
            }
        }

        usort($output, function ($a, $b) {
            return strcmp($a->getAttribute('name'), $b->getAttribute('name'));
        });

        return $output;
    }

    /**
     * @throws \Exception
     */
    public function getCountriesPhones(): array
    {
        $list = Config::getParam('locale-phones');
        /* @var $list array */
        $output = [];

        \asort($list);

        foreach ($list as $code => $name) {
            if ($this->locale->getText('countries.' . strtolower($code), false) !== false) {
                $output[] = new Document([
                    'code' => '+' . $name,
                    'countryCode' => $code,
                    'countryName' => $this->locale->getText('countries.' . strtolower($code)),
                ]);
            }
        }

        return $output;
    }

    /**
     * @throws \Exception
     */
    public function getContinents(): array
    {
        $list = Config::getParam('locale-continents');
        /* @var $list array */

        foreach ($list as $key => $value) {
            $output[] = new Document([
                'name' => $this->locale->getText('continents.' . strtolower($value)),
                'code' => $value,
            ]);
        }

        usort($output, function ($a, $b) {
            return strcmp($a->getAttribute('name'), $b->getAttribute('name'));
        });

        return $output;
    }

    /**
     * @throws \Exception
     */
    public function getCurrencies(): array
    {
        $list = Config::getParam('locale-currencies');

        return array_map(fn($node) => new Document($node), $list);
    }

    /**
     * @throws \Exception
     */
    public function getLanguages(): array
    {
        $list = Config::getParam('locale-languages');

        return array_map(fn($node) => new Document($node), $list);

    }
}