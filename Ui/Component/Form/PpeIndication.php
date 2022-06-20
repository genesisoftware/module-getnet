<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://www.fcamara.com.br/ for more information.
 *
 * @category  FCamara
 * @package   FCamara_
 * @copyright Copyright (c) 2020 FCamara Formação e Consultoria
 * @Agency    FCamara Formação e Consultoria, Inc. (http://www.fcamara.com.br)
 * @author    Danilo Cavalcanti de Moura <danilo.moura@fcamara.com.br>
 */

namespace FCamara\Getnet\Ui\Component\Form;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\DataObject;

class PpeIndication extends DataObject implements OptionSourceInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options = [];

        $options[] = ['value' => 'not_applied', 'label' => 'Não Aplicado'];
        $options[] = ['value' => 'in_exercise', 'label' => 'Em Exercício'];
        $options[] = ['value' => 'close_or_relative', 'label' => 'Próximo ou Relativo'];
        $options[] = ['value' => 'inactive_or_away', 'label' => 'Inativo ou Ausente'];

        return $options;
    }
}
