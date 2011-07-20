<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Builder\ODM;

use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListCollection;
use Sonata\AdminBundle\Builder\BaseListBuilder;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;

class ListBuilder extends BaseListBuilder
{

    /**
     * The method define the correct default settings for the provided FieldDescription
     *
     * @param \Sonata\AdminBundle\Admin\FieldDescription $fieldDescription
     * @return void
     */
    public function fixFieldDescription(AdminInterface $admin, FieldDescriptionInterface $fieldDescription, array $options = array())
    {
        if ($fieldDescription->getName() == '_action') {
            $this->buildActionFieldDescription($fieldDescription);
        }

        $fieldDescription->mergeOptions($options);
        $fieldDescription->setAdmin($admin);

        if ($admin->getModelManager()->hasMetadata($admin->getClass())) {
            $metadata = $admin->getModelManager()->getMetadata($admin->getClass());

            // set the default field mapping
            if (isset($metadata->fieldMappings[$fieldDescription->getName()])) {
                $fieldDescription->setFieldMapping($metadata->fieldMappings[$fieldDescription->getName()]);
                if ($fieldDescription->getOption('sortable') !== false) {
                    $fieldDescription->setOption('sortable', $fieldDescription->getOption('sortable', $fieldDescription->getName()));
                }
            }

            // set the default association mapping
            if (isset($metadata->associationMappings[$fieldDescription->getName()])) {
                $fieldDescription->setAssociationMapping($metadata->associationMappings[$fieldDescription->getName()]);
            }

            $fieldDescription->setOption('_sort_order', $fieldDescription->getOption('_sort_order', 'ASC'));
        }

        if (!$fieldDescription->getType()) {
            throw new \RuntimeException(sprintf('Please define a type for field `%s` in `%s`', $fieldDescription->getName(), get_class($admin)));
        }

        $fieldDescription->setOption('code', $fieldDescription->getOption('code', $fieldDescription->getName()));
        $fieldDescription->setOption('label', $fieldDescription->getOption('label', $fieldDescription->getName()));

        if (!$fieldDescription->getTemplate()) {

            $fieldDescription->setTemplate(sprintf('SonataAdminBundle:CRUD:list_%s.html.twig', $fieldDescription->getType()));

            if ($fieldDescription->getType() == ClassMetadata::REFERENCE_MANY) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_many_to_one.html.twig');
            }

            if ($fieldDescription->getType() == ClassMetadata::REFERENCE_ONE) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_one_to_one.html.twig');
            }

            if ($fieldDescription->getType() == ClassMetadata::ONE) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_one_to_many.html.twig');
            }

            if ($fieldDescription->getType() == ClassMetadata::MANY) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_many_to_many.html.twig');
            }
        }

        if ($fieldDescription->getType() == ClassMetadata::REFERENCE_MANY) {
            throw new \RuntimeException('Type not implemented yet');
            $admin->attachAdminClass($fieldDescription);
        }

        if ($fieldDescription->getType() == ClassMetadata::REFERENCE_ONE) {
            throw new \RuntimeException('Type not implemented yet');
            $admin->attachAdminClass($fieldDescription);
        }

        if ($fieldDescription->getType() == ClassMetadata::ONE) {
            throw new \RuntimeException('Type not implemented yet');
            $admin->attachAdminClass($fieldDescription);
        }

        if ($fieldDescription->getType() == ClassMetadata::MANY) {
            throw new \RuntimeException('Type not implemented yet');
            $admin->attachAdminClass($fieldDescription);
        }
    }
}