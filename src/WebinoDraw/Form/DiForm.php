<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoDraw for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoDraw\Form;

use Zend\Form\ElementInterface;
use Zend\Form\Form;
use Zend\Form\Factory;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Create form via DI
 *
 * @deprecated Use form factory service instead
 */
class DiForm implements FormInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var Factory
     */
    private $factory;

    /**
     *
     * @param array $config Form config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return Factory
     */
    public function getFormFactory()
    {
        return $this->factory;
    }

    /**
     * @param  Factory $factory
     * @return Form
     */
    public function setFormFactory(Factory $factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        if (null === $this->form) {
            $this->setForm($this->getFormFactory()->createForm($this->config));
        }
        return $this->form;
    }

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @param  array|\ArrayAccess $data
     * @return FormInterface
     */
    public function setData($data)
    {
        return $this->getForm()->setData($data);
    }

    /**
     * @param  object $object
     * @param  int $flags
     * @return mixed
     */
    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {
        return $this->getForm()->bind($object, $flags);
    }

    /**
     * @param  int $bindOnValidateFlag
     * @return void
     */
    public function setBindOnValidate($bindOnValidateFlag)
    {
        return $this->getForm()->setBindOnValidate($bindOnValidateFlag);
    }

    /**
     * @param  InputFilterInterface $inputFilter
     * @return FormInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        return $this->getForm()->setInputFilter($inputFilter);
    }

    /**
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->getForm()->getInputFilter();
    }

    /**
     * @param  bool $useInputFilterDefaults
     * @return Form
     */
    public function setUseInputFilterDefaults($useInputFilterDefaults)
    {
        return $this->getForm()->setUseInputFilterDefaults($useInputFilterDefaults);
    }

    /**
     * @return bool
     */
    public function useInputFilterDefaults()
    {
        return $this->getForm()->useInputFilterDefaults();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->getForm()->isValid();
    }

    /**
     * @param  int $flag
     * @return array|object
     */
    public function getData($flag = FormInterface::VALUES_NORMALIZED)
    {
        return $this->getForm()->getData($flag);
    }

    /**
     * @return FormInterface
     */
    public function setValidationGroup()
    {
        return $this->getForm()->setValidationGroup();
    }

    /**
     * @param  array $flags
     * @return FieldsetInterface
     */
    public function add($elementOrFieldset, array $flags = array())
    {
        return $this->getForm()->add($elementOrFieldset, $flags);
    }

    /**
     * @param  string $elementOrFieldset
     * @return bool
     */
    public function has($elementOrFieldset)
    {
        return $this->getForm()->has($elementOrFieldset);
    }

    /**
     * @param  string $elementOrFieldset
     * @return ElementInterface
     */
    public function get($elementOrFieldset)
    {
        return $this->getForm()->get($elementOrFieldset);
    }

    /**
     * @param  string $elementOrFieldset
     * @return FieldsetInterface
     */
    public function remove($elementOrFieldset)
    {
        return $this->getForm()->remove($elementOrFieldset);
    }

    /**
     * @param  string $elementOrFieldset
     * @param  int $priority
     * @return FieldsetInterface
     */
    public function setPriority($elementOrFieldset, $priority)
    {
        return $this->getForm()->setPriority($elementOrFieldset, $priority);
    }

    /**
     * @return array|\Traversable
     */
    public function getElements()
    {
        return $this->getForm()->getElements();
    }

    /**
     * @return array|\Traversable
     */
    public function getFieldsets()
    {
        return $this->getForm()->getFieldsets();
    }

    /**
     * @param  array|\Traversable $data
     * @return void
     */
    public function populateValues($data)
    {
        return $this->getForm()->populateValues($data);
    }

    /**
     * @param  $object
     * @return FieldsetInterface
     */
    public function setObject($object)
    {
        return $this->getForm()->setObject($object);
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->getForm()->getObject();
    }

    /**
     * @param $object
     * @return boolean
     */
    public function allowObjectBinding($object)
    {
        return $this->getForm()->allowObjectBinding($object);
    }

    /**
     * @param  HydratorInterface $hydrator
     * @return FieldsetInterface
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        return $this->getForm()->setHydrator($hydrator);
    }

    /**
     * @return null|HydratorInterface
     */
    public function getHydrator()
    {
        return $this->getForm()->getHydrator();
    }

    /**
     * @param  array $values
     * @return mixed
     */
    public function bindValues(array $values = array())
    {
        return $this->getForm()->bindValues($values);
    }

    /**
     * @return boolean
     */
    public function allowValueBinding()
    {
        return $this->getForm()->allowValueBinding();
    }

    /**
     * @param  string $name
     * @return ElementInterface
     */
    public function setName($name)
    {
        return $this->getForm()->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getForm()->getName();
    }

    /**
     * @param  array|\Traversable $options
     * @return ElementInterface
     */
    public function setOptions($options)
    {
        return $this->getForm()->setOptions($options);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->getForm()->getOptions();
    }

    /**
     * @param string $option
     * @return null|mixed
     */
    public function setOption($key, $value)
    {
        return $this->getForm()->setOption($key, $value);
    }

    /**
     * @param string $option
     * @return null|mixed
     */
    public function getOption($option)
    {
        return $this->getForm()->getOption($option);
    }

    /**
     * @param  string $key
     * @param  mixed $value
     * @return ElementInterface
     */
    public function setAttribute($key, $value)
    {
        return $this->getForm()->setAttribute($key, $value);
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->getForm()->getAttribute($key);
    }

    /**
     * @param  string $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return $this->getForm()->hasAttribute($key);
    }

    /**
     * @param  array|\Traversable $arrayOrTraversable
     * @return ElementInterface
     */
    public function setAttributes($arrayOrTraversable)
    {
        return $this->getForm()->setAttributes($arrayOrTraversable);
    }

    /**
     * @return array|\Traversable
     */
    public function getAttributes()
    {
        return $this->getForm()->getAttributes();
    }

    /**
     * @param  mixed $value
     * @return ElementInterface
     */
    public function setValue($value)
    {
        return $this->getForm()->setValue($value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getForm()->getValue();
    }

    /**
     * @param  $label
     * @return ElementInterface
     */
    public function setLabel($label)
    {
        return $this->getForm()->setLabel($label);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->getForm()->getLabel();
    }

    /**
     * @param  array|\Traversable $messages
     * @return ElementInterface
     */
    public function setMessages($messages)
    {
        return $this->getForm()->setMessages($messages);
    }

    /**
     * @return array|\Traversable
     */
    public function getMessages()
    {
        return $this->getForm()->getMessages();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->getForm()->count();
    }

    /**
     * @return PriorityQueue
     */
    public function getIterator()
    {
        return $this->getForm()->getIterator();
    }

    /**
     * @param FormInterface $form
     * @return void
     */
    public function prepareElement(FormInterface $form)
    {
        $this->getForm()->prepareElement($form);
    }
}
