<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\FormBundle\Form\Type\Document\JQuery;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

use Genemu\Bundle\FormBundle\Form\ChoiceList\AutocompleteDocumentChoiceList;

/**
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class AutocompleterType extends AbstractType
{
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        $defaultOptions = array(
            'choices'           => array(),
            'class'             => null,
            'document_manager'  => null,
            'expended'          => null,
            'multiple'          => false,
            'preferred_choices' => array(),
            'property'          => null,
            'query_builder'     => null,
            'template'          => 'choice',
            'route_name'        => null,
            'ajax'              => false
        );

        $options = array_replace($defaultOptions, $options);

        if ($options['route_name']) {
            $options['ajax'] = true;
        }

        $options['choice_list'] = new AutocompleteDocumentChoiceList(
            $this->registry->getManager($options['document_manager']),
            $options['class'],
            $options['property'],
            $options['query_builder'],
            $options['choices'],
            $options['ajax']
        );

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'genemu_jqueryautocompleter_document';
    }
}
