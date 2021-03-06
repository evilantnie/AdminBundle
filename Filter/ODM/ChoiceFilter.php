<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Filter\ODM;

use Symfony\Component\Form\FormFactory;

class ChoiceFilter extends Filter
{
    public function filter($queryBuilder, $alias, $field, $value)
    {
        if (!is_array($value)) {
            return;
        }

        if ($this->getField()->getAttribute('multiple')) {
            if (in_array('all', $value)) {
                return;
            }

            if (count($value) == 0) {
                return;
            }

            $queryBuilder->andWhere($queryBuilder->expr()->in(sprintf('%s.%s',
                $alias,
                $field
            ), $value));

        } else {

            if ($value === null || $value == 'all') {
                return;
            }

            $queryBuilder->andWhere(sprintf('%s.%s = :%s',
                $alias,
                $field,
                $this->getName()
            ));

            $queryBuilder->setParameter($this->getName(), $value);
        }
    }

    public function defineFieldBuilder(FormFactory $formFactory, $value = null)
    {
        $options = $this->getFieldDescription()->getOption('filter_field_options', array('required' => false));

        $this->field = $formFactory->createNamedBuilder('choice', $this->getName(), $value, $options)->getForm();
    }
}