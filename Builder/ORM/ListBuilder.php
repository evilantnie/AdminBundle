<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Builder\ORM;

use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
<<<<<<< HEAD
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;
use Sonata\AdminBundle\Builder\ListBuilderInterface;
=======
use Sonata\AdminBundle\Datagrid\ListCollection;
use Sonata\AdminBundle\Builder\BaseListBuilder;
>>>>>>> 185ea9c98241b44fcd73dd10c9fe32a63d9b77f3

use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ListBuilder extends BaseListBuilder
{
<<<<<<< HEAD
    public function getBaseList(array $options = array())
    {
        return new FieldDescriptionCollection;
    }

    public function addField(FieldDescriptionCollection $list, FieldDescriptionInterface $fieldDescription)
    {
        return $list->add($fieldDescription);
    }
=======
>>>>>>> 185ea9c98241b44fcd73dd10c9fe32a63d9b77f3

    /**
     * The method defines the correct default settings for the provided FieldDescription
     *
     * @param \Sonata\AdminBundle\Admin\AdminInterface $admin
     * @param \Sonata\AdminBundle\Admin\FieldDescriptionInterface $fieldDescription
     * @param array $options
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

            if ($fieldDescription->getType() == ClassMetadataInfo::MANY_TO_ONE) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_many_to_one.html.twig');
            }

            if ($fieldDescription->getType() == ClassMetadataInfo::ONE_TO_ONE) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_one_to_one.html.twig');
            }

            if ($fieldDescription->getType() == ClassMetadataInfo::ONE_TO_MANY) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_one_to_many.html.twig');
            }

            if ($fieldDescription->getType() == ClassMetadataInfo::MANY_TO_MANY) {
                $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list_orm_many_to_many.html.twig');
            }
        }

        if ($fieldDescription->getType() == ClassMetadataInfo::MANY_TO_ONE) {
            $admin->attachAdminClass($fieldDescription);
        }

        if ($fieldDescription->getType() == ClassMetadataInfo::ONE_TO_ONE) {
            $admin->attachAdminClass($fieldDescription);
        }

        if ($fieldDescription->getType() == ClassMetadataInfo::ONE_TO_MANY) {
            $admin->attachAdminClass($fieldDescription);
        }

        if ($fieldDescription->getType() == ClassMetadataInfo::MANY_TO_MANY) {
            $admin->attachAdminClass($fieldDescription);
        }
    }
<<<<<<< HEAD

    /**
     * @param \Sonata\AdminBundle\Admin\FieldDescriptionInterface $fieldDescription
     * @return \Sonata\AdminBundle\Admin\FieldDescriptionInterface
     */
    public function buildActionFieldDescription(FieldDescriptionInterface $fieldDescription)
    {
        if (null === $fieldDescription->getTemplate()) {
            $fieldDescription->setTemplate('SonataAdminBundle:CRUD:list__action.html.twig');
        }

        if (null === $fieldDescription->getType()) {
            $fieldDescription->setType('action');
        }

        if (null === $fieldDescription->getOption('name')) {
            $fieldDescription->setOption('name', 'Action');
        }

        if (null === $fieldDescription->getOption('code')) {
            $fieldDescription->setOption('code', 'Action');
        }

        if (null !== $fieldDescription->getOption('actions')) {
            $actions = $fieldDescription->getOption('actions');
            foreach ($actions as $k => $action) {
                if (!isset($action['template'])) {
                    $actions[$k]['template'] = sprintf('SonataAdminBundle:CRUD:list__action_%s.html.twig', $k);
                }
            }

            $fieldDescription->setOption('actions', $actions);
        }

        return $fieldDescription;
    }
=======
>>>>>>> 185ea9c98241b44fcd73dd10c9fe32a63d9b77f3
}