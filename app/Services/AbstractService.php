<?php

namespace App\Services;

use App\Constants\Constants;

/**
 * Servico abstrato para uso em todas as services do projeto.
 *
 * @category Services
 * @package  \App\Services
 * @author   Talysson Lima <diegotalysson@gmail.com>
 * @version  GIT $Id$
 */
abstract class AbstractService
{
    /**
     * Verifica se a propriedade e existe na classe e ela tem valor preenchido
     *
     * @param object $object
     * @param string $property
     *
     * @return bool
     */
    public function propertyValueExists($object, $property)
    {
        return $object && (property_exists($object, $property) && $object->{$property});
    }

    /**
     * Verifica se a propriedade e existe na classe e ela tem valor preenchido
     *
     * @param object $sort
     * @param string $column
     *
     * @return object
     */
    public function orderByValueExists($sort, $column)
    {
        $order = [
            Constants::FIELD => $column,
            Constants::DIRECTION => Constants::ASC
        ];
        if ($this->propertyValueExists($sort, Constants::FIELD)) {
            $order[Constants::FIELD] = $sort->field;
        }
        
        if ($this->propertyValueExists($sort, Constants::DIRECTION)) {
            $order[Constants::DIRECTION] =  $sort->direction;
        }
        return (object) $order;
    }
}
