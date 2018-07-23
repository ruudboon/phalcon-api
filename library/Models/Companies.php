<?php

declare(strict_types=1);

namespace Niden\Models;

use Niden\Constants\Relationships;
use Niden\Mvc\Model\AbstractModel;
use Phalcon\Filter;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class Companies
 *
 * @package Niden\Models
 */
class Companies extends AbstractModel
{
    /**
     * Initialize relationships and model properties
     */
    public function initialize()
    {
        $this->hasMany(
            'com_id',
            Individuals::class,
            'ind_com_id',
            [
                'alias'    => Relationships::INDIVIDUALS,
                'reusable' => true,
            ]
        );

        $this->hasMany(
            'com_id',
            Products::class,
            'prd_com_id',
            [
                'alias'    => Relationships::PRODUCTS,
                'reusable' => true,
            ]
        );

        parent::initialize();
    }

    /**
     * Column map to help with the API
     *
     * @return array<string,string>
     */
    public function columnMap(): array
    {
        return [
            'com_id'        => 'id',
            'com_name'      => 'name',
            'com_address'   => 'address',
            'com_city'      => 'city',
            'com_telephone' => 'phone',
        ];
    }

    /**
     * Model filters
     *
     * @return array<string,string>
     */
    public function getModelFilters(): array
    {
        return [
            'id'      => Filter::FILTER_ABSINT,
            'name'    => Filter::FILTER_STRING,
            'address' => Filter::FILTER_STRING,
            'city'    => Filter::FILTER_STRING,
            'phone'   => Filter::FILTER_STRING,
        ];
    }

    /**
     * Returns the source table from the database
     *
     * @return string
     */
    public function getSource(): string
    {
        return 'co_companies';
    }

    /**
     * Table prefix
     *
     * @return string
     */
    public function getTablePrefix(): string
    {
        return 'com';
    }

    /**
     * Validates the company name
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();
        $validator->add(
            'name',
            new Uniqueness(
                [
                    'message' => 'The company name already exists in the database',
                ]
            )
        );

        return $this->validate($validator);
    }
}
