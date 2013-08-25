<?php 
return array (
  'Zend\\Form\\Factory' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setInputFilterFactory' => 0,
      'setFormElementManager' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'Zend\\Form\\Factory::__construct:0' => 
        array (
          0 => 'formElementManager',
          1 => 'Zend\\Form\\FormElementManager',
          2 => false,
          3 => NULL,
        ),
      ),
      'setInputFilterFactory' => 
      array (
        'Zend\\Form\\Factory::setInputFilterFactory:0' => 
        array (
          0 => 'inputFilterFactory',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFormElementManager' => 
      array (
        'Zend\\Form\\Factory::setFormElementManager:0' => 
        array (
          0 => 'formElementManager',
          1 => 'Zend\\Form\\FormElementManager',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Form\\DiForm' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Form\\FormInterface',
      1 => 'Countable',
      2 => 'IteratorAggregate',
      3 => 'Traversable',
      4 => 'Zend\\Form\\ElementInterface',
      5 => 'Zend\\Form\\ElementPrepareAwareInterface',
      6 => 'Zend\\Form\\FormFactoryAwareInterface',
      7 => 'Zend\\Form\\FieldsetInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFormFactory' => 3,
      'setForm' => 0,
      'setData' => 0,
      'setBindOnValidate' => 0,
      'setInputFilter' => 0,
      'setUseInputFilterDefaults' => 0,
      'setValidationGroup' => 0,
      'setPriority' => 0,
      'setObject' => 0,
      'setHydrator' => 0,
      'setName' => 0,
      'setOptions' => 0,
      'setAttribute' => 0,
      'setAttributes' => 0,
      'setValue' => 0,
      'setLabel' => 0,
      'setMessages' => 0,
      'prepareElement' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Form\\DiForm::__construct:0' => 
        array (
          0 => 'config',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFormFactory' => 
      array (
        'WebinoDraw\\Form\\DiForm::setFormFactory:0' => 
        array (
          0 => 'factory',
          1 => 'Zend\\Form\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setForm' => 
      array (
        'WebinoDraw\\Form\\DiForm::setForm:0' => 
        array (
          0 => 'form',
          1 => 'Zend\\Form\\FormInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setData' => 
      array (
        'WebinoDraw\\Form\\DiForm::setData:0' => 
        array (
          0 => 'data',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setBindOnValidate' => 
      array (
        'WebinoDraw\\Form\\DiForm::setBindOnValidate:0' => 
        array (
          0 => 'bindOnValidateFlag',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilter' => 
      array (
        'WebinoDraw\\Form\\DiForm::setInputFilter:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\InputFilterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setUseInputFilterDefaults' => 
      array (
        'WebinoDraw\\Form\\DiForm::setUseInputFilterDefaults:0' => 
        array (
          0 => 'useInputFilterDefaults',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setPriority' => 
      array (
        'WebinoDraw\\Form\\DiForm::setPriority:0' => 
        array (
          0 => 'elementOrFieldset',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Form\\DiForm::setPriority:1' => 
        array (
          0 => 'priority',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setObject' => 
      array (
        'WebinoDraw\\Form\\DiForm::setObject:0' => 
        array (
          0 => 'object',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setHydrator' => 
      array (
        'WebinoDraw\\Form\\DiForm::setHydrator:0' => 
        array (
          0 => 'hydrator',
          1 => 'Zend\\Stdlib\\Hydrator\\HydratorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setName' => 
      array (
        'WebinoDraw\\Form\\DiForm::setName:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'WebinoDraw\\Form\\DiForm::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAttribute' => 
      array (
        'WebinoDraw\\Form\\DiForm::setAttribute:0' => 
        array (
          0 => 'key',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Form\\DiForm::setAttribute:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAttributes' => 
      array (
        'WebinoDraw\\Form\\DiForm::setAttributes:0' => 
        array (
          0 => 'arrayOrTraversable',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValue' => 
      array (
        'WebinoDraw\\Form\\DiForm::setValue:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLabel' => 
      array (
        'WebinoDraw\\Form\\DiForm::setLabel:0' => 
        array (
          0 => 'label',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMessages' => 
      array (
        'WebinoDraw\\Form\\DiForm::setMessages:0' => 
        array (
          0 => 'messages',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'prepareElement' => 
      array (
        'WebinoDraw\\Form\\DiForm::prepareElement:0' => 
        array (
          0 => 'form',
          1 => 'Zend\\Form\\FormInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Form\\View\\Helper\\FormElement' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      1 => 'Zend\\View\\Helper\\HelperInterface',
      2 => 'Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      5 => 'Zend\\View\\Helper\\AbstractHelper',
      6 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setTranslator' => 3,
      'setTranslatorEnabled' => 3,
      'setTranslatorTextDomain' => 3,
      'setView' => 0,
      'getTranslator' => 3,
      'hasTranslator' => 3,
      'isTranslatorEnabled' => 3,
      'getTranslatorTextDomain' => 3,
    ),
    'parameters' => 
    array (
      'setTranslator' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormElement::setTranslator:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\Translator',
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Form\\View\\Helper\\FormElement::setTranslator:1' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setTranslatorEnabled' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormElement::setTranslatorEnabled:0' => 
        array (
          0 => 'enabled',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormElement::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormElement::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Form\\View\\Helper\\FormCollection' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      1 => 'Zend\\View\\Helper\\HelperInterface',
      2 => 'Zend\\Form\\View\\Helper\\FormCollection',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      5 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
      6 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      7 => 'Zend\\View\\Helper\\HelperInterface',
      8 => 'Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper',
      9 => 'Zend\\View\\Helper\\HelperInterface',
      10 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      11 => 'Zend\\View\\Helper\\AbstractHelper',
      12 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setShouldWrap' => 0,
      'setDefaultElementHelper' => 0,
      'setElementHelper' => 0,
      'setFieldsetHelper' => 0,
      'setDoctype' => 0,
      'setEncoding' => 0,
      'setTranslator' => 3,
      'setTranslatorEnabled' => 3,
      'setTranslatorTextDomain' => 3,
      'setView' => 0,
      'getTranslator' => 3,
      'hasTranslator' => 3,
      'isTranslatorEnabled' => 3,
      'getTranslatorTextDomain' => 3,
    ),
    'parameters' => 
    array (
      'setShouldWrap' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setShouldWrap:0' => 
        array (
          0 => 'wrap',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefaultElementHelper' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setDefaultElementHelper:0' => 
        array (
          0 => 'defaultSubHelper',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setElementHelper' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setElementHelper:0' => 
        array (
          0 => 'elementHelper',
          1 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFieldsetHelper' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setFieldsetHelper:0' => 
        array (
          0 => 'fieldsetHelper',
          1 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setDoctype' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setDoctype:0' => 
        array (
          0 => 'doctype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEncoding' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setEncoding:0' => 
        array (
          0 => 'encoding',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslator' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setTranslator:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\Translator',
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setTranslator:1' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setTranslatorEnabled' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setTranslatorEnabled:0' => 
        array (
          0 => 'enabled',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormCollection::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Form\\View\\Helper\\FormRow' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      1 => 'Zend\\View\\Helper\\HelperInterface',
      2 => 'Zend\\Form\\View\\Helper\\FormRow',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      5 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
      6 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      7 => 'Zend\\View\\Helper\\HelperInterface',
      8 => 'Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper',
      9 => 'Zend\\View\\Helper\\HelperInterface',
      10 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      11 => 'Zend\\View\\Helper\\AbstractHelper',
      12 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setElementHelper' => 0,
      'setInputErrorClass' => 0,
      'setLabelAttributes' => 0,
      'setLabelPosition' => 0,
      'setRenderErrors' => 0,
      'setPartial' => 0,
      'setDoctype' => 0,
      'setEncoding' => 0,
      'setTranslator' => 3,
      'setTranslatorEnabled' => 3,
      'setTranslatorTextDomain' => 3,
      'setView' => 0,
      'getTranslator' => 3,
      'hasTranslator' => 3,
      'isTranslatorEnabled' => 3,
      'getTranslatorTextDomain' => 3,
    ),
    'parameters' => 
    array (
      'setElementHelper' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setElementHelper:0' => 
        array (
          0 => 'elementHelper',
          1 => 'Zend\\View\\Helper\\AbstractHelper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputErrorClass' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setInputErrorClass:0' => 
        array (
          0 => 'inputErrorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLabelAttributes' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setLabelAttributes:0' => 
        array (
          0 => 'labelAttributes',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLabelPosition' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setLabelPosition:0' => 
        array (
          0 => 'labelPosition',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRenderErrors' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setRenderErrors:0' => 
        array (
          0 => 'renderErrors',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setPartial' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setPartial:0' => 
        array (
          0 => 'partial',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDoctype' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setDoctype:0' => 
        array (
          0 => 'doctype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEncoding' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setEncoding:0' => 
        array (
          0 => 'encoding',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslator' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setTranslator:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\Translator',
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setTranslator:1' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setTranslatorEnabled' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setTranslatorEnabled:0' => 
        array (
          0 => 'enabled',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormRow::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\DrawEvent' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventInterface',
      1 => 'Zend\\EventManager\\Event',
      2 => 'Zend\\EventManager\\EventInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setHelper' => 0,
      'setNodes' => 0,
      'setSpec' => 0,
      'setParams' => 0,
      'setName' => 0,
      'setTarget' => 0,
      'setParam' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\DrawEvent::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\DrawEvent::__construct:1' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\DrawEvent::__construct:2' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setHelper' => 
      array (
        'WebinoDraw\\DrawEvent::setHelper:0' => 
        array (
          0 => 'helper',
          1 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setNodes' => 
      array (
        'WebinoDraw\\DrawEvent::setNodes:0' => 
        array (
          0 => 'nodes',
          1 => 'WebinoDraw\\Dom\\NodeList',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\DrawEvent::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParams' => 
      array (
        'WebinoDraw\\DrawEvent::setParams:0' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setName' => 
      array (
        'WebinoDraw\\DrawEvent::setName:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTarget' => 
      array (
        'WebinoDraw\\DrawEvent::setTarget:0' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParam' => 
      array (
        'WebinoDraw\\DrawEvent::setParam:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\DrawEvent::setParam:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Module' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ModuleManager\\Feature\\AutoloaderProviderInterface',
      1 => 'Zend\\ModuleManager\\Feature\\ConfigProviderInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\AjaxEvent' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventInterface',
      1 => 'Zend\\EventManager\\Event',
      2 => 'Zend\\EventManager\\EventInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setJson' => 0,
      'setFragmentXpath' => 0,
      'setParams' => 0,
      'setName' => 0,
      'setTarget' => 0,
      'setParam' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\AjaxEvent::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\AjaxEvent::__construct:1' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\AjaxEvent::__construct:2' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setJson' => 
      array (
        'WebinoDraw\\AjaxEvent::setJson:0' => 
        array (
          0 => 'json',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFragmentXpath' => 
      array (
        'WebinoDraw\\AjaxEvent::setFragmentXpath:0' => 
        array (
          0 => 'xpath',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParams' => 
      array (
        'WebinoDraw\\AjaxEvent::setParams:0' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setName' => 
      array (
        'WebinoDraw\\AjaxEvent::setName:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTarget' => 
      array (
        'WebinoDraw\\AjaxEvent::setTarget:0' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParam' => 
      array (
        'WebinoDraw\\AjaxEvent::setParam:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\AjaxEvent::setParam:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\WebinoDraw' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setOptions' => 0,
      'setInstructions' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\WebinoDraw::__construct:0' => 
        array (
          0 => 'renderer',
          1 => 'Zend\\View\\Renderer\\PhpRenderer',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\WebinoDraw::__construct:1' => 
        array (
          0 => 'options',
          1 => 'WebinoDraw\\WebinoDrawOptions',
          2 => false,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'WebinoDraw\\WebinoDraw::setOptions:0' => 
        array (
          0 => 'options',
          1 => 'WebinoDraw\\WebinoDrawOptions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructions' => 
      array (
        'WebinoDraw\\WebinoDraw::setInstructions:0' => 
        array (
          0 => 'instructions',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Exception\\ExceptionInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Exception\\InvalidArgumentException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Exception\\ExceptionInterface',
      1 => 'InvalidArgumentException',
      2 => 'LogicException',
      3 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Exception\\InvalidArgumentException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\InvalidArgumentException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\InvalidArgumentException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Exception\\DOMCreationException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Exception\\ExceptionInterface',
      1 => 'RuntimeException',
      2 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Exception\\DOMCreationException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\DOMCreationException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\DOMCreationException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Exception\\MissingPropertyException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Exception\\ExceptionInterface',
      1 => 'InvalidArgumentException',
      2 => 'LogicException',
      3 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Exception\\MissingPropertyException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\MissingPropertyException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\MissingPropertyException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Exception\\DrawException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Exception\\ExceptionInterface',
      1 => 'RuntimeException',
      2 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Exception\\DrawException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\DrawException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\DrawException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Exception\\RuntimeException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Exception\\ExceptionInterface',
      1 => 'RuntimeException',
      2 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Exception\\RuntimeException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\RuntimeException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\RuntimeException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Exception\\InvalidInstructionException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Exception\\ExceptionInterface',
      1 => 'WebinoDraw\\Exception\\InvalidArgumentException',
      2 => 'WebinoDraw\\Exception\\ExceptionInterface',
      3 => 'InvalidArgumentException',
      4 => 'LogicException',
      5 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Exception\\InvalidInstructionException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\InvalidInstructionException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\InvalidInstructionException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Ajax\\Json' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'WebinoDraw\\Stdlib\\ArrayMergeInterface',
      6 => 'ArrayObject',
      7 => 'IteratorAggregate',
      8 => 'Traversable',
      9 => 'ArrayAccess',
      10 => 'Serializable',
      11 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Ajax\\Json::__construct:0' => 
        array (
          0 => 'array',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlags' => 
      array (
        'WebinoDraw\\Ajax\\Json::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoDraw\\Ajax\\Json::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Ajax\\FragmentXpath' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Ajax\\FragmentXpath::__construct:0' => 
        array (
          0 => 'string',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Mvc\\Service\\DrawStrategyFactory' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\FactoryInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Mvc\\Service\\ServiceViewHelperFactory' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\FactoryInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Mvc\\Service\\WebinoDrawFactory' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\FactoryInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\DrawFormEvent' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventInterface',
      1 => 'WebinoDraw\\DrawEvent',
      2 => 'Zend\\EventManager\\EventInterface',
      3 => 'Zend\\EventManager\\Event',
      4 => 'Zend\\EventManager\\EventInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setForm' => 0,
      'setHelper' => 0,
      'setNodes' => 0,
      'setSpec' => 0,
      'setParams' => 0,
      'setName' => 0,
      'setTarget' => 0,
      'setParam' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\DrawFormEvent::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\DrawFormEvent::__construct:1' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\DrawFormEvent::__construct:2' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setForm' => 
      array (
        'WebinoDraw\\DrawFormEvent::setForm:0' => 
        array (
          0 => 'form',
          1 => 'Zend\\Form\\FormInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setHelper' => 
      array (
        'WebinoDraw\\DrawFormEvent::setHelper:0' => 
        array (
          0 => 'helper',
          1 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setNodes' => 
      array (
        'WebinoDraw\\DrawFormEvent::setNodes:0' => 
        array (
          0 => 'nodes',
          1 => 'WebinoDraw\\Dom\\NodeList',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\DrawFormEvent::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParams' => 
      array (
        'WebinoDraw\\DrawFormEvent::setParams:0' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setName' => 
      array (
        'WebinoDraw\\DrawFormEvent::setName:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTarget' => 
      array (
        'WebinoDraw\\DrawFormEvent::setTarget:0' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParam' => 
      array (
        'WebinoDraw\\DrawFormEvent::setParam:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\DrawFormEvent::setParam:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Stdlib\\ArrayFetchInterface' => 
  array (
    'supertypes' => 
    array (
      0 => 'ArrayAccess',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Stdlib\\DrawInstructionsInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Stdlib\\DrawInstructions' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'WebinoDraw\\Stdlib\\DrawInstructionsInterface',
      6 => 'ArrayObject',
      7 => 'IteratorAggregate',
      8 => 'Traversable',
      9 => 'ArrayAccess',
      10 => 'Serializable',
      11 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setLocator' => 0,
      'setNodeListPrototype' => 0,
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Stdlib\\DrawInstructions::__construct:0' => 
        array (
          0 => 'array',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setLocator' => 
      array (
        'WebinoDraw\\Stdlib\\DrawInstructions::setLocator:0' => 
        array (
          0 => 'locator',
          1 => 'WebinoDraw\\Dom\\Locator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setNodeListPrototype' => 
      array (
        'WebinoDraw\\Stdlib\\DrawInstructions::setNodeListPrototype:0' => 
        array (
          0 => 'nodeListPrototype',
          1 => 'WebinoDraw\\Dom\\NodeList',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlags' => 
      array (
        'WebinoDraw\\Stdlib\\DrawInstructions::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoDraw\\Stdlib\\DrawInstructions::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Stdlib\\ArrayMergeInterface' => 
  array (
    'supertypes' => 
    array (
      0 => 'ArrayAccess',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Stdlib\\Translation' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'WebinoDraw\\Stdlib\\ArrayFetchInterface',
      6 => 'WebinoDraw\\Stdlib\\ArrayMergeInterface',
      7 => 'ArrayObject',
      8 => 'IteratorAggregate',
      9 => 'Traversable',
      10 => 'ArrayAccess',
      11 => 'Serializable',
      12 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Stdlib\\Translation::__construct:0' => 
        array (
          0 => 'array',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlags' => 
      array (
        'WebinoDraw\\Stdlib\\Translation::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoDraw\\Stdlib\\Translation::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Stdlib\\VarTranslator' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\View\\Helper\\AbstractDrawElement' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'WebinoDraw\\View\\Helper\\AbstractDrawHelper',
      5 => 'Zend\\View\\Helper\\HelperInterface',
      6 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      7 => 'Zend\\EventManager\\EventManagerAwareInterface',
      8 => 'Zend\\EventManager\\EventsCapableInterface',
      9 => 'Zend\\View\\Helper\\AbstractHelper',
      10 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawElement::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\DrawTranslate' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'WebinoDraw\\View\\Helper\\DrawElement',
      5 => 'Zend\\View\\Helper\\HelperInterface',
      6 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      7 => 'Zend\\EventManager\\EventManagerAwareInterface',
      8 => 'Zend\\EventManager\\EventsCapableInterface',
      9 => 'WebinoDraw\\View\\Helper\\AbstractDrawElement',
      10 => 'Zend\\EventManager\\EventsCapableInterface',
      11 => 'Zend\\EventManager\\EventManagerAwareInterface',
      12 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      13 => 'Zend\\View\\Helper\\HelperInterface',
      14 => 'WebinoDraw\\View\\Helper\\AbstractDrawHelper',
      15 => 'Zend\\View\\Helper\\HelperInterface',
      16 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      17 => 'Zend\\EventManager\\EventManagerAwareInterface',
      18 => 'Zend\\EventManager\\EventsCapableInterface',
      19 => 'Zend\\View\\Helper\\AbstractHelper',
      20 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawTranslate::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\DrawPagination' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      5 => 'WebinoDraw\\View\\Helper\\DrawElement',
      6 => 'Zend\\View\\Helper\\HelperInterface',
      7 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      8 => 'Zend\\EventManager\\EventManagerAwareInterface',
      9 => 'Zend\\EventManager\\EventsCapableInterface',
      10 => 'WebinoDraw\\View\\Helper\\AbstractDrawElement',
      11 => 'Zend\\EventManager\\EventsCapableInterface',
      12 => 'Zend\\EventManager\\EventManagerAwareInterface',
      13 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      14 => 'Zend\\View\\Helper\\HelperInterface',
      15 => 'WebinoDraw\\View\\Helper\\AbstractDrawHelper',
      16 => 'Zend\\View\\Helper\\HelperInterface',
      17 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      18 => 'Zend\\EventManager\\EventManagerAwareInterface',
      19 => 'Zend\\EventManager\\EventsCapableInterface',
      20 => 'Zend\\View\\Helper\\AbstractHelper',
      21 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setServiceLocator' => 3,
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
      'getServiceLocator' => 3,
    ),
    'parameters' => 
    array (
      'setServiceLocator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setServiceLocator:0' => 
        array (
          0 => 'serviceLocator',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawPagination::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\DrawForm' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      3 => 'Zend\\View\\Helper\\HelperInterface',
      4 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      5 => 'WebinoDraw\\View\\Helper\\AbstractDrawHelper',
      6 => 'Zend\\View\\Helper\\HelperInterface',
      7 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      8 => 'Zend\\EventManager\\EventManagerAwareInterface',
      9 => 'Zend\\EventManager\\EventsCapableInterface',
      10 => 'Zend\\View\\Helper\\AbstractHelper',
      11 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setEvent' => 0,
      'setServiceLocator' => 3,
      'setFormCollectionHelper' => 0,
      'setFormRowHelper' => 0,
      'setFormElementHelper' => 0,
      'setTranslatorTextDomain' => 0,
      'setRenderErrors' => 0,
      'setCache' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
      'getServiceLocator' => 3,
    ),
    'parameters' => 
    array (
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setServiceLocator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setServiceLocator:0' => 
        array (
          0 => 'serviceLocator',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFormCollectionHelper' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setFormCollectionHelper:0' => 
        array (
          0 => 'helper',
          1 => 'Zend\\Form\\View\\Helper\\FormCollection',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFormRowHelper' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setFormRowHelper:0' => 
        array (
          0 => 'helper',
          1 => 'Zend\\Form\\View\\Helper\\FormRow',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFormElementHelper' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setFormElementHelper:0' => 
        array (
          0 => 'helper',
          1 => 'Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setRenderErrors' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setRenderErrors:0' => 
        array (
          0 => 'bool',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawForm::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\DrawHelperInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setVars' => 0,
    ),
    'parameters' => 
    array (
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawHelperInterface::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\DrawAbsolutize' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      2 => 'Zend\\EventManager\\EventManagerAwareInterface',
      3 => 'Zend\\EventManager\\EventsCapableInterface',
      4 => 'WebinoDraw\\View\\Helper\\AbstractDrawElement',
      5 => 'Zend\\EventManager\\EventsCapableInterface',
      6 => 'Zend\\EventManager\\EventManagerAwareInterface',
      7 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      8 => 'Zend\\View\\Helper\\HelperInterface',
      9 => 'WebinoDraw\\View\\Helper\\AbstractDrawHelper',
      10 => 'Zend\\View\\Helper\\HelperInterface',
      11 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      12 => 'Zend\\EventManager\\EventManagerAwareInterface',
      13 => 'Zend\\EventManager\\EventsCapableInterface',
      14 => 'Zend\\View\\Helper\\AbstractHelper',
      15 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawAbsolutize::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\DrawElement' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      2 => 'Zend\\EventManager\\EventManagerAwareInterface',
      3 => 'Zend\\EventManager\\EventsCapableInterface',
      4 => 'WebinoDraw\\View\\Helper\\AbstractDrawElement',
      5 => 'Zend\\EventManager\\EventsCapableInterface',
      6 => 'Zend\\EventManager\\EventManagerAwareInterface',
      7 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      8 => 'Zend\\View\\Helper\\HelperInterface',
      9 => 'WebinoDraw\\View\\Helper\\AbstractDrawHelper',
      10 => 'Zend\\View\\Helper\\HelperInterface',
      11 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      12 => 'Zend\\EventManager\\EventManagerAwareInterface',
      13 => 'Zend\\EventManager\\EventsCapableInterface',
      14 => 'Zend\\View\\Helper\\AbstractHelper',
      15 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\DrawElement::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Helper\\AbstractDrawHelper' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'WebinoDraw\\View\\Helper\\DrawHelperInterface',
      2 => 'Zend\\EventManager\\EventManagerAwareInterface',
      3 => 'Zend\\EventManager\\EventsCapableInterface',
      4 => 'Zend\\View\\Helper\\AbstractHelper',
      5 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setFilterPluginManager' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
      'setInstructionsPrototype' => 0,
      'setView' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilterPluginManager' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setFilterPluginManager:0' => 
        array (
          0 => 'filterManager',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionsPrototype' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setInstructionsPrototype:0' => 
        array (
          0 => 'instructionsPrototype',
          1 => 'WebinoDraw\\Stdlib\\DrawInstructions',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoDraw\\View\\Helper\\AbstractDrawHelper::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\ListenerAggregateInterface',
      1 => 'Zend\\View\\Strategy\\PhpRendererStrategy',
      2 => 'Zend\\EventManager\\ListenerAggregateInterface',
      3 => 'Zend\\EventManager\\AbstractListenerAggregate',
      4 => 'Zend\\EventManager\\ListenerAggregateInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      '__construct' => 3,
      'setContentPlaceholders' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy::__construct:0' => 
        array (
          0 => 'service',
          1 => 'WebinoDraw\\WebinoDraw',
          2 => true,
          3 => NULL,
        ),
      ),
      'setContentPlaceholders' => 
      array (
        'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy::setContentPlaceholders:0' => 
        array (
          0 => 'contentPlaceholders',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Strategy\\DrawAjaxJsonStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'Zend\\EventManager\\ListenerAggregateInterface',
      3 => 'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy',
      4 => 'Zend\\EventManager\\ListenerAggregateInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'Zend\\EventManager\\EventsCapableInterface',
      7 => 'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy',
      8 => 'Zend\\EventManager\\ListenerAggregateInterface',
      9 => 'Zend\\View\\Strategy\\PhpRendererStrategy',
      10 => 'Zend\\EventManager\\ListenerAggregateInterface',
      11 => 'Zend\\EventManager\\AbstractListenerAggregate',
      12 => 'Zend\\EventManager\\ListenerAggregateInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setContentPlaceholders' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxJsonStrategy::__construct:0' => 
        array (
          0 => 'service',
          1 => 'WebinoDraw\\WebinoDraw',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxJsonStrategy::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\AjaxEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxJsonStrategy::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setContentPlaceholders' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxJsonStrategy::setContentPlaceholders:0' => 
        array (
          0 => 'contentPlaceholders',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\ListenerAggregateInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'Zend\\EventManager\\EventsCapableInterface',
      3 => 'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy',
      4 => 'Zend\\EventManager\\ListenerAggregateInterface',
      5 => 'Zend\\View\\Strategy\\PhpRendererStrategy',
      6 => 'Zend\\EventManager\\ListenerAggregateInterface',
      7 => 'Zend\\EventManager\\AbstractListenerAggregate',
      8 => 'Zend\\EventManager\\ListenerAggregateInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      '__construct' => 3,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setContentPlaceholders' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy::__construct:0' => 
        array (
          0 => 'service',
          1 => 'WebinoDraw\\WebinoDraw',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\AjaxEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setContentPlaceholders' => 
      array (
        'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy::setContentPlaceholders:0' => 
        array (
          0 => 'contentPlaceholders',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Strategy\\DrawStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\ListenerAggregateInterface',
      1 => 'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy',
      2 => 'Zend\\EventManager\\ListenerAggregateInterface',
      3 => 'Zend\\View\\Strategy\\PhpRendererStrategy',
      4 => 'Zend\\EventManager\\ListenerAggregateInterface',
      5 => 'Zend\\EventManager\\AbstractListenerAggregate',
      6 => 'Zend\\EventManager\\ListenerAggregateInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setContentPlaceholders' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawStrategy::__construct:0' => 
        array (
          0 => 'service',
          1 => 'WebinoDraw\\WebinoDraw',
          2 => true,
          3 => NULL,
        ),
      ),
      'setContentPlaceholders' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawStrategy::setContentPlaceholders:0' => 
        array (
          0 => 'contentPlaceholders',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Strategy\\DrawAjaxHtmlStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'Zend\\EventManager\\ListenerAggregateInterface',
      3 => 'WebinoDraw\\View\\Strategy\\AbstractDrawAjaxStrategy',
      4 => 'Zend\\EventManager\\ListenerAggregateInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'Zend\\EventManager\\EventsCapableInterface',
      7 => 'WebinoDraw\\View\\Strategy\\AbstractDrawStrategy',
      8 => 'Zend\\EventManager\\ListenerAggregateInterface',
      9 => 'Zend\\View\\Strategy\\PhpRendererStrategy',
      10 => 'Zend\\EventManager\\ListenerAggregateInterface',
      11 => 'Zend\\EventManager\\AbstractListenerAggregate',
      12 => 'Zend\\EventManager\\ListenerAggregateInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setContentPlaceholders' => 0,
      'getEventManager' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxHtmlStrategy::__construct:0' => 
        array (
          0 => 'service',
          1 => 'WebinoDraw\\WebinoDraw',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxHtmlStrategy::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\AjaxEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxHtmlStrategy::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setContentPlaceholders' => 
      array (
        'WebinoDraw\\View\\Strategy\\DrawAjaxHtmlStrategy::setContentPlaceholders:0' => 
        array (
          0 => 'contentPlaceholders',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Dom\\Locator' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'ArrayObject',
      6 => 'IteratorAggregate',
      7 => 'Traversable',
      8 => 'ArrayAccess',
      9 => 'Serializable',
      10 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setTransformator' => 0,
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Dom\\Locator::__construct:0' => 
        array (
          0 => 'input',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setTransformator' => 
      array (
        'WebinoDraw\\Dom\\Locator::setTransformator:0' => 
        array (
          0 => 'transformator',
          1 => 'WebinoDraw\\Dom\\Locator\\Transformator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlags' => 
      array (
        'WebinoDraw\\Dom\\Locator::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoDraw\\Dom\\Locator::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Dom\\NodeList' => 
  array (
    'supertypes' => 
    array (
      0 => 'IteratorAggregate',
      1 => 'Traversable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setNodes' => 0,
      'setEscapeHtml' => 0,
      'setLocator' => 0,
      'setValue' => 0,
      'setHtml' => 0,
      'setAttribs' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Dom\\NodeList::__construct:0' => 
        array (
          0 => 'nodes',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setNodes' => 
      array (
        'WebinoDraw\\Dom\\NodeList::setNodes:0' => 
        array (
          0 => 'nodes',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEscapeHtml' => 
      array (
        'WebinoDraw\\Dom\\NodeList::setEscapeHtml:0' => 
        array (
          0 => 'escapeHtml',
          1 => 'Zend\\View\\Helper\\EscapeHtml',
          2 => true,
          3 => NULL,
        ),
      ),
      'setLocator' => 
      array (
        'WebinoDraw\\Dom\\NodeList::setLocator:0' => 
        array (
          0 => 'locator',
          1 => 'WebinoDraw\\Dom\\Locator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setValue' => 
      array (
        'WebinoDraw\\Dom\\NodeList::setValue:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\NodeList::setValue:1' => 
        array (
          0 => 'preSet',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setHtml' => 
      array (
        'WebinoDraw\\Dom\\NodeList::setHtml:0' => 
        array (
          0 => 'xhtml',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\NodeList::setHtml:1' => 
        array (
          0 => 'preSet',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setAttribs' => 
      array (
        'WebinoDraw\\Dom\\NodeList::setAttribs:0' => 
        array (
          0 => 'attribs',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\NodeList::setAttribs:1' => 
        array (
          0 => 'preSet',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Dom\\Element' => 
  array (
    'supertypes' => 
    array (
      0 => 'DOMElement',
      1 => 'DOMNode',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setAttribute' => 0,
      'setAttributeNode' => 0,
      'setAttributeNS' => 0,
      'setAttributeNodeNS' => 0,
      'setIdAttribute' => 0,
      'setIdAttributeNS' => 0,
      'setIdAttributeNode' => 0,
      'setUserData' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Dom\\Element::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::__construct:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::__construct:2' => 
        array (
          0 => 'uri',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setAttribute' => 
      array (
        'WebinoDraw\\Dom\\Element::setAttribute:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setAttribute:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAttributeNode' => 
      array (
        'WebinoDraw\\Dom\\Element::setAttributeNode:0' => 
        array (
          0 => 'newAttr',
          1 => 'DOMAttr',
          2 => true,
          3 => NULL,
        ),
      ),
      'setAttributeNS' => 
      array (
        'WebinoDraw\\Dom\\Element::setAttributeNS:0' => 
        array (
          0 => 'namespaceURI',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setAttributeNS:1' => 
        array (
          0 => 'qualifiedName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setAttributeNS:2' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAttributeNodeNS' => 
      array (
        'WebinoDraw\\Dom\\Element::setAttributeNodeNS:0' => 
        array (
          0 => 'newAttr',
          1 => 'DOMAttr',
          2 => true,
          3 => NULL,
        ),
      ),
      'setIdAttribute' => 
      array (
        'WebinoDraw\\Dom\\Element::setIdAttribute:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setIdAttribute:1' => 
        array (
          0 => 'isId',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIdAttributeNS' => 
      array (
        'WebinoDraw\\Dom\\Element::setIdAttributeNS:0' => 
        array (
          0 => 'namespaceURI',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setIdAttributeNS:1' => 
        array (
          0 => 'localName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setIdAttributeNS:2' => 
        array (
          0 => 'isId',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIdAttributeNode' => 
      array (
        'WebinoDraw\\Dom\\Element::setIdAttributeNode:0' => 
        array (
          0 => 'attr',
          1 => 'DOMAttr',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setIdAttributeNode:1' => 
        array (
          0 => 'isId',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setUserData' => 
      array (
        'WebinoDraw\\Dom\\Element::setUserData:0' => 
        array (
          0 => 'key',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setUserData:1' => 
        array (
          0 => 'data',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setUserData:2' => 
        array (
          0 => 'handler',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Dom\\Locator\\StrategyFactory' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Dom\\Locator\\TransformatorInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Dom\\Locator\\Strategy\\CssStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Dom\\Locator\\TransformatorInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Dom\\Locator\\Strategy\\XpathStrategy' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Dom\\Locator\\TransformatorInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Dom\\Locator\\Transformator' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'WebinoDraw\\Dom\\Locator\\TransformatorInterface',
      6 => 'ArrayObject',
      7 => 'IteratorAggregate',
      8 => 'Traversable',
      9 => 'ArrayAccess',
      10 => 'Serializable',
      11 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setStrategyFactory' => 0,
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Dom\\Locator\\Transformator::__construct:0' => 
        array (
          0 => 'array',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setStrategyFactory' => 
      array (
        'WebinoDraw\\Dom\\Locator\\Transformator::setStrategyFactory:0' => 
        array (
          0 => 'factory',
          1 => 'WebinoDraw\\Dom\\Locator\\StrategyFactory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlags' => 
      array (
        'WebinoDraw\\Dom\\Locator\\Transformator::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoDraw\\Dom\\Locator\\Transformator::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\WebinoDrawOptions' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Stdlib\\ParameterObjectInterface',
      1 => 'Zend\\Stdlib\\AbstractOptions',
      2 => 'Zend\\Stdlib\\ParameterObjectInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setInstructions' => 0,
      'setInstructionSet' => 0,
      'setAjaxContainerXpath' => 0,
      'setAjaxFragmentXpath' => 0,
      'setFromArray' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\WebinoDrawOptions::__construct:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setInstructions' => 
      array (
        'WebinoDraw\\WebinoDrawOptions::setInstructions:0' => 
        array (
          0 => 'instructions',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setInstructionSet' => 
      array (
        'WebinoDraw\\WebinoDrawOptions::setInstructionSet:0' => 
        array (
          0 => 'instructionSet',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAjaxContainerXpath' => 
      array (
        'WebinoDraw\\WebinoDrawOptions::setAjaxContainerXpath:0' => 
        array (
          0 => 'ajaxContainerXpath',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAjaxFragmentXpath' => 
      array (
        'WebinoDraw\\WebinoDrawOptions::setAjaxFragmentXpath:0' => 
        array (
          0 => 'ajaxFragmentXpath',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFromArray' => 
      array (
        'WebinoDraw\\WebinoDrawOptions::setFromArray:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
);
