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
  'Zend\\Form\\View\\Helper\\FormCollection' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      2 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
      3 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      4 => 'Zend\\View\\Helper\\HelperInterface',
      5 => 'Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper',
      6 => 'Zend\\View\\Helper\\HelperInterface',
      7 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      8 => 'Zend\\View\\Helper\\AbstractHelper',
      9 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setShouldWrap' => 0,
      'setDefaultElementHelper' => 0,
      'setElementHelper' => 0,
      'setFieldsetHelper' => 0,
      'setWrapper' => 0,
      'setLabelWrapper' => 0,
      'setTemplateWrapper' => 0,
      'setDoctype' => 0,
      'setEncoding' => 0,
      'setTranslator' => 3,
      'setTranslatorEnabled' => 3,
      'setTranslatorTextDomain' => 3,
      'setView' => 0,
    ),
    'parameters' => 
    array (
      'setShouldWrap' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setShouldWrap:0' => 
        array (
          0 => 'wrap',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefaultElementHelper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setDefaultElementHelper:0' => 
        array (
          0 => 'defaultSubHelper',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setElementHelper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setElementHelper:0' => 
        array (
          0 => 'elementHelper',
          1 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFieldsetHelper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setFieldsetHelper:0' => 
        array (
          0 => 'fieldsetHelper',
          1 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setWrapper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setWrapper:0' => 
        array (
          0 => 'wrapper',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLabelWrapper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setLabelWrapper:0' => 
        array (
          0 => 'labelWrapper',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTemplateWrapper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setTemplateWrapper:0' => 
        array (
          0 => 'templateWrapper',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDoctype' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setDoctype:0' => 
        array (
          0 => 'doctype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEncoding' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setEncoding:0' => 
        array (
          0 => 'encoding',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslator' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setTranslator:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\TranslatorInterface',
          2 => false,
          3 => NULL,
        ),
        'Zend\\Form\\View\\Helper\\FormCollection::setTranslator:1' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setTranslatorEnabled' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setTranslatorEnabled:0' => 
        array (
          0 => 'enabled',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setView' => 
      array (
        'Zend\\Form\\View\\Helper\\FormCollection::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\Form\\View\\Helper\\FormElement' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'Zend\\View\\Helper\\AbstractHelper',
      2 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setDefaultHelper' => 0,
      'setView' => 0,
    ),
    'parameters' => 
    array (
      'setDefaultHelper' => 
      array (
        'Zend\\Form\\View\\Helper\\FormElement::setDefaultHelper:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'Zend\\Form\\View\\Helper\\FormElement::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\Form\\View\\Helper\\FormRow' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      2 => 'Zend\\Form\\View\\Helper\\AbstractHelper',
      3 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      4 => 'Zend\\View\\Helper\\HelperInterface',
      5 => 'Zend\\I18n\\View\\Helper\\AbstractTranslatorHelper',
      6 => 'Zend\\View\\Helper\\HelperInterface',
      7 => 'Zend\\I18n\\Translator\\TranslatorAwareInterface',
      8 => 'Zend\\View\\Helper\\AbstractHelper',
      9 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
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
    ),
    'parameters' => 
    array (
      'setInputErrorClass' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setInputErrorClass:0' => 
        array (
          0 => 'inputErrorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLabelAttributes' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setLabelAttributes:0' => 
        array (
          0 => 'labelAttributes',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLabelPosition' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setLabelPosition:0' => 
        array (
          0 => 'labelPosition',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRenderErrors' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setRenderErrors:0' => 
        array (
          0 => 'renderErrors',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setPartial' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setPartial:0' => 
        array (
          0 => 'partial',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDoctype' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setDoctype:0' => 
        array (
          0 => 'doctype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEncoding' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setEncoding:0' => 
        array (
          0 => 'encoding',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslator' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setTranslator:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\TranslatorInterface',
          2 => false,
          3 => NULL,
        ),
        'Zend\\Form\\View\\Helper\\FormRow::setTranslator:1' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setTranslatorEnabled' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setTranslatorEnabled:0' => 
        array (
          0 => 'enabled',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setView' => 
      array (
        'Zend\\Form\\View\\Helper\\FormRow::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\Filter\\FilterPluginManager' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
      2 => 'Zend\\ServiceManager\\AbstractPluginManager',
      3 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
      4 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      5 => 'Zend\\ServiceManager\\ServiceManager',
      6 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setService' => 0,
      'setServiceLocator' => 3,
      'setAllowOverride' => 0,
      'setShareByDefault' => 0,
      'setThrowExceptionInCreate' => 0,
      'setRetrieveFromPeeringManagerFirst' => 0,
      'setInvokableClass' => 0,
      'setFactory' => 0,
      'setShared' => 0,
      'setAlias' => 0,
      'setCanonicalNames' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'Zend\\Filter\\FilterPluginManager::__construct:0' => 
        array (
          0 => 'configuration',
          1 => 'Zend\\ServiceManager\\ConfigInterface',
          2 => false,
          3 => NULL,
        ),
      ),
      'setService' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setService:1' => 
        array (
          0 => 'service',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setService:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setServiceLocator' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setServiceLocator:0' => 
        array (
          0 => 'serviceLocator',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowOverride' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setAllowOverride:0' => 
        array (
          0 => 'allowOverride',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setShareByDefault' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setShareByDefault:0' => 
        array (
          0 => 'shareByDefault',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setThrowExceptionInCreate' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setThrowExceptionInCreate:0' => 
        array (
          0 => 'throwExceptionInCreate',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRetrieveFromPeeringManagerFirst' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setRetrieveFromPeeringManagerFirst:0' => 
        array (
          0 => 'retrieveFromPeeringManagerFirst',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setInvokableClass' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setInvokableClass:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setInvokableClass:1' => 
        array (
          0 => 'invokableClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setInvokableClass:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setFactory' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setFactory:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setFactory:1' => 
        array (
          0 => 'factory',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setFactory:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setShared' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setShared:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setShared:1' => 
        array (
          0 => 'isShared',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAlias' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setAlias:0' => 
        array (
          0 => 'alias',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Filter\\FilterPluginManager::setAlias:1' => 
        array (
          0 => 'nameOrAlias',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setCanonicalNames' => 
      array (
        'Zend\\Filter\\FilterPluginManager::setCanonicalNames:0' => 
        array (
          0 => 'canonicalNames',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\View\\HelperPluginManager' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
      2 => 'Zend\\ServiceManager\\AbstractPluginManager',
      3 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
      4 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      5 => 'Zend\\ServiceManager\\ServiceManager',
      6 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setRenderer' => 0,
      'setService' => 0,
      'setServiceLocator' => 3,
      'setAllowOverride' => 0,
      'setShareByDefault' => 0,
      'setThrowExceptionInCreate' => 0,
      'setRetrieveFromPeeringManagerFirst' => 0,
      'setInvokableClass' => 0,
      'setFactory' => 0,
      'setShared' => 0,
      'setAlias' => 0,
      'setCanonicalNames' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'Zend\\View\\HelperPluginManager::__construct:0' => 
        array (
          0 => 'configuration',
          1 => 'Zend\\ServiceManager\\ConfigInterface',
          2 => false,
          3 => NULL,
        ),
      ),
      'setRenderer' => 
      array (
        'Zend\\View\\HelperPluginManager::setRenderer:0' => 
        array (
          0 => 'renderer',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setService' => 
      array (
        'Zend\\View\\HelperPluginManager::setService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setService:1' => 
        array (
          0 => 'service',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setService:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setServiceLocator' => 
      array (
        'Zend\\View\\HelperPluginManager::setServiceLocator:0' => 
        array (
          0 => 'serviceLocator',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowOverride' => 
      array (
        'Zend\\View\\HelperPluginManager::setAllowOverride:0' => 
        array (
          0 => 'allowOverride',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setShareByDefault' => 
      array (
        'Zend\\View\\HelperPluginManager::setShareByDefault:0' => 
        array (
          0 => 'shareByDefault',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setThrowExceptionInCreate' => 
      array (
        'Zend\\View\\HelperPluginManager::setThrowExceptionInCreate:0' => 
        array (
          0 => 'throwExceptionInCreate',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRetrieveFromPeeringManagerFirst' => 
      array (
        'Zend\\View\\HelperPluginManager::setRetrieveFromPeeringManagerFirst:0' => 
        array (
          0 => 'retrieveFromPeeringManagerFirst',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setInvokableClass' => 
      array (
        'Zend\\View\\HelperPluginManager::setInvokableClass:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setInvokableClass:1' => 
        array (
          0 => 'invokableClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setInvokableClass:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setFactory' => 
      array (
        'Zend\\View\\HelperPluginManager::setFactory:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setFactory:1' => 
        array (
          0 => 'factory',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setFactory:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setShared' => 
      array (
        'Zend\\View\\HelperPluginManager::setShared:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setShared:1' => 
        array (
          0 => 'isShared',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAlias' => 
      array (
        'Zend\\View\\HelperPluginManager::setAlias:0' => 
        array (
          0 => 'alias',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\View\\HelperPluginManager::setAlias:1' => 
        array (
          0 => 'nameOrAlias',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setCanonicalNames' => 
      array (
        'Zend\\View\\HelperPluginManager::setCanonicalNames:0' => 
        array (
          0 => 'canonicalNames',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\View\\Helper\\BasePath' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'Zend\\View\\Helper\\AbstractHelper',
      2 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setBasePath' => 0,
      'setView' => 0,
    ),
    'parameters' => 
    array (
      'setBasePath' => 
      array (
        'Zend\\View\\Helper\\BasePath::setBasePath:0' => 
        array (
          0 => 'basePath',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'Zend\\View\\Helper\\BasePath::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\View\\Helper\\EscapeHtml' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'Zend\\View\\Helper\\Escaper\\AbstractHelper',
      2 => 'Zend\\View\\Helper\\HelperInterface',
      3 => 'Zend\\View\\Helper\\AbstractHelper',
      4 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setEncoding' => 0,
      'setEscaper' => 0,
      'setView' => 0,
    ),
    'parameters' => 
    array (
      'setEncoding' => 
      array (
        'Zend\\View\\Helper\\EscapeHtml::setEncoding:0' => 
        array (
          0 => 'encoding',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEscaper' => 
      array (
        'Zend\\View\\Helper\\EscapeHtml::setEscaper:0' => 
        array (
          0 => 'escaper',
          1 => 'Zend\\Escaper\\Escaper',
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'Zend\\View\\Helper\\EscapeHtml::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\View\\Helper\\ServerUrl' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Helper\\HelperInterface',
      1 => 'Zend\\View\\Helper\\AbstractHelper',
      2 => 'Zend\\View\\Helper\\HelperInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setHost' => 0,
      'setPort' => 0,
      'setScheme' => 0,
      'setUseProxy' => 0,
      'setView' => 0,
    ),
    'parameters' => 
    array (
      'setHost' => 
      array (
        'Zend\\View\\Helper\\ServerUrl::setHost:0' => 
        array (
          0 => 'host',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setPort' => 
      array (
        'Zend\\View\\Helper\\ServerUrl::setPort:0' => 
        array (
          0 => 'port',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setScheme' => 
      array (
        'Zend\\View\\Helper\\ServerUrl::setScheme:0' => 
        array (
          0 => 'scheme',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setUseProxy' => 
      array (
        'Zend\\View\\Helper\\ServerUrl::setUseProxy:0' => 
        array (
          0 => 'useProxy',
          1 => NULL,
          2 => false,
          3 => false,
        ),
      ),
      'setView' => 
      array (
        'Zend\\View\\Helper\\ServerUrl::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
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
      'setOption' => 0,
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
      'setOption' => 
      array (
        'WebinoDraw\\Form\\DiForm::setOption:0' => 
        array (
          0 => 'key',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Form\\DiForm::setOption:1' => 
        array (
          0 => 'value',
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
    ),
    'parameters' => 
    array (
      'setTranslator' => 
      array (
        'WebinoDraw\\Form\\View\\Helper\\FormElement::setTranslator:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\TranslatorInterface',
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
          1 => 'Zend\\I18n\\Translator\\TranslatorInterface',
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
  'WebinoDraw\\Config' => 
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
      'setVar' => 0,
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
          1 => 'WebinoDraw\\Helper\\DrawHelperInterface',
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
      'setVar' => 
      array (
        'WebinoDraw\\DrawEvent::setVar:0' => 
        array (
          0 => 'key',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\DrawEvent::setVar:1' => 
        array (
          0 => 'value',
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
  'WebinoDraw\\LoopCallback' => 
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
  'WebinoDraw\\HelperPluginManager' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
      2 => 'Zend\\ServiceManager\\AbstractPluginManager',
      3 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
      4 => 'Zend\\ServiceManager\\ServiceLocatorAwareInterface',
      5 => 'Zend\\ServiceManager\\ServiceManager',
      6 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setService' => 0,
      'setServiceLocator' => 3,
      'setAllowOverride' => 0,
      'setShareByDefault' => 0,
      'setThrowExceptionInCreate' => 0,
      'setRetrieveFromPeeringManagerFirst' => 0,
      'setInvokableClass' => 0,
      'setFactory' => 0,
      'setShared' => 0,
      'setAlias' => 0,
      'setCanonicalNames' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\HelperPluginManager::__construct:0' => 
        array (
          0 => 'configuration',
          1 => 'Zend\\ServiceManager\\ConfigInterface',
          2 => false,
          3 => NULL,
        ),
      ),
      'setService' => 
      array (
        'WebinoDraw\\HelperPluginManager::setService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setService:1' => 
        array (
          0 => 'service',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setService:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setServiceLocator' => 
      array (
        'WebinoDraw\\HelperPluginManager::setServiceLocator:0' => 
        array (
          0 => 'serviceLocator',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowOverride' => 
      array (
        'WebinoDraw\\HelperPluginManager::setAllowOverride:0' => 
        array (
          0 => 'allowOverride',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setShareByDefault' => 
      array (
        'WebinoDraw\\HelperPluginManager::setShareByDefault:0' => 
        array (
          0 => 'shareByDefault',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setThrowExceptionInCreate' => 
      array (
        'WebinoDraw\\HelperPluginManager::setThrowExceptionInCreate:0' => 
        array (
          0 => 'throwExceptionInCreate',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRetrieveFromPeeringManagerFirst' => 
      array (
        'WebinoDraw\\HelperPluginManager::setRetrieveFromPeeringManagerFirst:0' => 
        array (
          0 => 'retrieveFromPeeringManagerFirst',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setInvokableClass' => 
      array (
        'WebinoDraw\\HelperPluginManager::setInvokableClass:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setInvokableClass:1' => 
        array (
          0 => 'invokableClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setInvokableClass:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setFactory' => 
      array (
        'WebinoDraw\\HelperPluginManager::setFactory:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setFactory:1' => 
        array (
          0 => 'factory',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setFactory:2' => 
        array (
          0 => 'shared',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setShared' => 
      array (
        'WebinoDraw\\HelperPluginManager::setShared:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setShared:1' => 
        array (
          0 => 'isShared',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAlias' => 
      array (
        'WebinoDraw\\HelperPluginManager::setAlias:0' => 
        array (
          0 => 'alias',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\HelperPluginManager::setAlias:1' => 
        array (
          0 => 'nameOrAlias',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setCanonicalNames' => 
      array (
        'WebinoDraw\\HelperPluginManager::setCanonicalNames:0' => 
        array (
          0 => 'canonicalNames',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\ModuleManager\\Feature\\WebinoDrawHelperProviderInterface' => 
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
  'WebinoDraw\\Instructions\\InstructionsRenderer' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Instructions\\InstructionsRendererInterface',
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
        'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:0' => 
        array (
          0 => 'drawHelpers',
          1 => 'WebinoDraw\\HelperPluginManager',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:1' => 
        array (
          0 => 'locator',
          1 => 'WebinoDraw\\Dom\\Locator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:2' => 
        array (
          0 => 'nodeListFactory',
          1 => 'WebinoDraw\\Dom\\NodeListFactory',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:3' => 
        array (
          0 => 'instructionsFactory',
          1 => 'WebinoDraw\\Instructions\\InstructionsFactory',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Instructions\\InstructionsRenderer::__construct:4' => 
        array (
          0 => 'drawOptions',
          1 => 'WebinoDraw\\WebinoDrawOptions',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Instructions\\InstructionsInterface' => 
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
  'WebinoDraw\\Instructions\\InstructionsFactory' => 
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
  'WebinoDraw\\Instructions\\Instructions' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'WebinoDraw\\Instructions\\InstructionsInterface',
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
        'WebinoDraw\\Instructions\\Instructions::__construct:0' => 
        array (
          0 => 'array',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
        ),
      ),
      'setFlags' => 
      array (
        'WebinoDraw\\Instructions\\Instructions::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoDraw\\Instructions\\Instructions::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Instructions\\InstructionsRendererInterface' => 
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
  'WebinoDraw\\WebinoDraw' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setInstructions' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\WebinoDraw::__construct:0' => 
        array (
          0 => 'options',
          1 => 'WebinoDraw\\WebinoDrawOptions',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\WebinoDraw::__construct:1' => 
        array (
          0 => 'instructionsFactory',
          1 => 'WebinoDraw\\Instructions\\InstructionsFactory',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\WebinoDraw::__construct:2' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
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
  'WebinoDraw\\Exception\\InvalidHelperException' => 
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
        'WebinoDraw\\Exception\\InvalidHelperException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\InvalidHelperException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoDraw\\Exception\\InvalidHelperException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
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
  'WebinoDraw\\Mvc\\Service\\WebinoDrawHelperManagerFactory' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\FactoryInterface',
      1 => 'Zend\\Mvc\\Service\\AbstractPluginManagerFactory',
      2 => 'Zend\\ServiceManager\\FactoryInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Mvc\\Service\\WebinoDrawOptionsFactory' => 
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
      'setVar' => 0,
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
          1 => 'WebinoDraw\\Helper\\DrawHelperInterface',
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
      'setVar' => 
      array (
        'WebinoDraw\\DrawFormEvent::setVar:0' => 
        array (
          0 => 'key',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\DrawFormEvent::setVar:1' => 
        array (
          0 => 'value',
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
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Stdlib\\VarTranslator::__construct:0' => 
        array (
          0 => 'helpers',
          1 => 'Zend\\View\\HelperPluginManager',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Stdlib\\VarTranslator::__construct:1' => 
        array (
          0 => 'filters',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\View\\Renderer\\DrawRenderer' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\View\\Renderer\\RendererInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setResolver' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\View\\Renderer\\DrawRenderer::__construct:0' => 
        array (
          0 => 'webinoDraw',
          1 => 'WebinoDraw\\WebinoDraw',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\View\\Renderer\\DrawRenderer::__construct:1' => 
        array (
          0 => 'renderer',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setResolver' => 
      array (
        'WebinoDraw\\View\\Renderer\\DrawRenderer::setResolver:0' => 
        array (
          0 => 'resolver',
          1 => 'Zend\\View\\Resolver\\ResolverInterface',
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
  'WebinoDraw\\View\\Strategy\\DrawStrategyFactory' => 
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
  'WebinoDraw\\Helper\\DrawAbsolutizeFactory' => 
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
  'WebinoDraw\\Helper\\AbstractDrawElement' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      3 => 'WebinoDraw\\Helper\\AbstractDrawHelper',
      4 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawElement::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\DrawTranslate' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      3 => 'WebinoDraw\\Helper\\DrawElement',
      4 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'Zend\\EventManager\\EventsCapableInterface',
      7 => 'WebinoDraw\\Helper\\AbstractDrawElement',
      8 => 'Zend\\EventManager\\EventsCapableInterface',
      9 => 'Zend\\EventManager\\EventManagerAwareInterface',
      10 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      11 => 'WebinoDraw\\Helper\\AbstractDrawHelper',
      12 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      13 => 'Zend\\EventManager\\EventManagerAwareInterface',
      14 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::__construct:0' => 
        array (
          0 => 'translator',
          1 => 'Zend\\I18n\\Translator\\TranslatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\DrawTranslate::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\DrawPagination' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      3 => 'WebinoDraw\\Helper\\DrawElement',
      4 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'Zend\\EventManager\\EventsCapableInterface',
      7 => 'WebinoDraw\\Helper\\AbstractDrawElement',
      8 => 'Zend\\EventManager\\EventsCapableInterface',
      9 => 'Zend\\EventManager\\EventManagerAwareInterface',
      10 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      11 => 'WebinoDraw\\Helper\\AbstractDrawHelper',
      12 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      13 => 'Zend\\EventManager\\EventManagerAwareInterface',
      14 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::__construct:0' => 
        array (
          0 => 'services',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\DrawPagination::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\DrawFormFactory' => 
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
  'WebinoDraw\\Helper\\DrawForm\\FormProvider' => 
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
  'WebinoDraw\\Helper\\DrawForm\\FormRenderer' => 
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
  'WebinoDraw\\Helper\\DrawForm' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventsCapableInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      3 => 'WebinoDraw\\Helper\\AbstractDrawHelper',
      4 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setEvent' => 0,
      'setTranslatorTextDomain' => 0,
      'setRenderErrors' => 0,
      'setCache' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::__construct:0' => 
        array (
          0 => 'forms',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawForm::__construct:1' => 
        array (
          0 => 'formRow',
          1 => 'Zend\\Form\\View\\Helper\\FormRow',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawForm::__construct:2' => 
        array (
          0 => 'formElement',
          1 => 'WebinoDraw\\Form\\View\\Helper\\FormElement',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawForm::__construct:3' => 
        array (
          0 => 'formElementErrors',
          1 => 'Zend\\Form\\View\\Helper\\FormElementErrors',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawForm::__construct:4' => 
        array (
          0 => 'formCollection',
          1 => 'Zend\\Form\\View\\Helper\\FormCollection',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawForm::__construct:5' => 
        array (
          0 => 'url',
          1 => 'Zend\\View\\Helper\\Url',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawForm::__construct:6' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslatorTextDomain' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setTranslatorTextDomain:0' => 
        array (
          0 => 'textDomain',
          1 => NULL,
          2 => false,
          3 => 'default',
        ),
      ),
      'setRenderErrors' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setRenderErrors:0' => 
        array (
          0 => 'bool',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\DrawForm::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\DrawHelperInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setSpec' => 0,
      'setVars' => 0,
    ),
    'parameters' => 
    array (
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\DrawHelperInterface::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\DrawHelperInterface::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\DrawAbsolutize' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'Zend\\EventManager\\EventsCapableInterface',
      3 => 'WebinoDraw\\Helper\\AbstractDrawElement',
      4 => 'Zend\\EventManager\\EventsCapableInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      7 => 'WebinoDraw\\Helper\\AbstractDrawHelper',
      8 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      9 => 'Zend\\EventManager\\EventManagerAwareInterface',
      10 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::__construct:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawAbsolutize::__construct:1' => 
        array (
          0 => 'serverUrl',
          1 => 'Zend\\View\\Helper\\ServerUrl',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Helper\\DrawAbsolutize::__construct:2' => 
        array (
          0 => 'basePath',
          1 => 'Zend\\View\\Helper\\BasePath',
          2 => true,
          3 => NULL,
        ),
      ),
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\DrawAbsolutize::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\DrawElement' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'Zend\\EventManager\\EventsCapableInterface',
      3 => 'WebinoDraw\\Helper\\AbstractDrawElement',
      4 => 'Zend\\EventManager\\EventsCapableInterface',
      5 => 'Zend\\EventManager\\EventManagerAwareInterface',
      6 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      7 => 'WebinoDraw\\Helper\\AbstractDrawHelper',
      8 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      9 => 'Zend\\EventManager\\EventManagerAwareInterface',
      10 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\DrawElement::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Helper\\AbstractDrawHelper' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Helper\\DrawHelperInterface',
      1 => 'Zend\\EventManager\\EventManagerAwareInterface',
      2 => 'Zend\\EventManager\\EventsCapableInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setCache' => 0,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setManipulator' => 0,
      'setSpec' => 0,
      'setVars' => 0,
      'setVarTranslator' => 0,
      'setTranslationPrototype' => 0,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\StorageInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoDraw\\DrawEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setManipulator' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setManipulator:0' => 
        array (
          0 => 'manipulator',
          1 => 'WebinoDraw\\Manipulator\\Manipulator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVars' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setVars:0' => 
        array (
          0 => 'vars',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslator' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setVarTranslator:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslationPrototype' => 
      array (
        'WebinoDraw\\Helper\\AbstractDrawHelper::setTranslationPrototype:0' => 
        array (
          0 => 'translationPrototype',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Manipulator' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setPlugin' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Manipulator\\Manipulator::__construct:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
      'setPlugin' => 
      array (
        'WebinoDraw\\Manipulator\\Manipulator::setPlugin:0' => 
        array (
          0 => 'plugin',
          1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Manipulator\\Manipulator::setPlugin:1' => 
        array (
          0 => 'priority',
          1 => NULL,
          2 => false,
          3 => 1,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Html' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\Html::__construct:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Manipulator\\Plugin\\Html::__construct:1' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\OnVar' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\OnVar::__construct:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Manipulator\\Plugin\\OnVar::__construct:1' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Replace' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
      2 => 'WebinoDraw\\Manipulator\\Plugin\\PostLoopPluginInterface',
      3 => 'WebinoDraw\\Manipulator\\Plugin\\AbstractPlugin',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Fragments' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\Fragments::__construct:0' => 
        array (
          0 => 'locator',
          1 => 'WebinoDraw\\Dom\\Locator',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Remove' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\Remove::__construct:0' => 
        array (
          0 => 'locator',
          1 => 'WebinoDraw\\Dom\\Locator',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Attribs' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
      2 => 'WebinoDraw\\Manipulator\\Plugin\\AbstractPlugin',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Loop' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\PreLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
      2 => 'WebinoDraw\\Manipulator\\Plugin\\AbstractPlugin',
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
        'WebinoDraw\\Manipulator\\Plugin\\Loop::__construct:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Manipulator\\Plugin\\Loop::__construct:1' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\PluginArgument' => 
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
      'setHelper' => 0,
      'setNode' => 0,
      'setNodes' => 0,
      'setSpec' => 0,
      'setTranslation' => 0,
      'setVarTranslation' => 0,
      'setFromArray' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::__construct:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setHelper' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setHelper:0' => 
        array (
          0 => 'helper',
          1 => 'WebinoDraw\\Helper\\DrawHelperInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setNode' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setNode:0' => 
        array (
          0 => 'node',
          1 => 'WebinoDraw\\Dom\\NodeInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setNodes' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setNodes:0' => 
        array (
          0 => 'nodes',
          1 => 'WebinoDraw\\Dom\\NodeList',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSpec' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setSpec:0' => 
        array (
          0 => 'spec',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTranslation' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setTranslation:0' => 
        array (
          0 => 'translation',
          1 => 'WebinoDraw\\Stdlib\\Translation',
          2 => true,
          3 => NULL,
        ),
      ),
      'setVarTranslation' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setVarTranslation:0' => 
        array (
          0 => 'varTranslation',
          1 => 'WebinoDraw\\Stdlib\\Translation',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFromArray' => 
      array (
        'WebinoDraw\\Manipulator\\Plugin\\PluginArgument::setFromArray:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\PluginInterface' => 
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
  'WebinoDraw\\Manipulator\\Plugin\\PostLoopPluginInterface' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\VarTranslation' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\VarTranslation::__construct:0' => 
        array (
          0 => 'varTranslator',
          1 => 'WebinoDraw\\Stdlib\\VarTranslator',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\SubInstructions' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\SubInstructions::__construct:0' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\NodeTranslation' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Render' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\PreLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\Render::__construct:0' => 
        array (
          0 => 'renderer',
          1 => 'Zend\\View\\Renderer\\PhpRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\PreLoopPluginInterface' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\OnEmpty' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\OnEmpty::__construct:0' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Value' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
      2 => 'WebinoDraw\\Manipulator\\Plugin\\AbstractPlugin',
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
        'WebinoDraw\\Manipulator\\Plugin\\Value::__construct:0' => 
        array (
          0 => 'escapeHtml',
          1 => 'Zend\\View\\Helper\\EscapeHtml',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\Cdata' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Manipulator\\Plugin\\InLoopPluginInterface',
      1 => 'WebinoDraw\\Manipulator\\Plugin\\PluginInterface',
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
        'WebinoDraw\\Manipulator\\Plugin\\Cdata::__construct:0' => 
        array (
          0 => 'instructionsRenderer',
          1 => 'WebinoDraw\\Instructions\\InstructionsRenderer',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Manipulator\\Plugin\\AbstractPlugin' => 
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
  'WebinoDraw\\Dom\\NodeInterface' => 
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
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Dom\\Locator::__construct:0' => 
        array (
          0 => 'transformator',
          1 => 'WebinoDraw\\Dom\\Locator\\Transformator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Locator::__construct:1' => 
        array (
          0 => 'input',
          1 => NULL,
          2 => false,
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
          0 => 'locator',
          1 => 'WebinoDraw\\Dom\\Locator',
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\NodeList::__construct:1' => 
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
      0 => 'WebinoDraw\\Dom\\NodeInterface',
      1 => 'DOMElement',
      2 => 'DOMNode',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setAttributes' => 0,
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
      'setAttributes' => 
      array (
        'WebinoDraw\\Dom\\Element::setAttributes:0' => 
        array (
          0 => 'attribs',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Element::setAttributes:1' => 
        array (
          0 => 'callback',
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
          2 => false,
          3 => 
          array (
          ),
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
  'WebinoDraw\\Dom\\Attr' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoDraw\\Dom\\NodeInterface',
      1 => 'DOMAttr',
      2 => 'DOMNode',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setUserData' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDraw\\Dom\\Attr::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Attr::__construct:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setUserData' => 
      array (
        'WebinoDraw\\Dom\\Attr::setUserData:0' => 
        array (
          0 => 'key',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Attr::setUserData:1' => 
        array (
          0 => 'data',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoDraw\\Dom\\Attr::setUserData:2' => 
        array (
          0 => 'handler',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDraw\\Dom\\NodeListFactory' => 
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
        'WebinoDraw\\Dom\\NodeListFactory::__construct:0' => 
        array (
          0 => 'services',
          1 => 'Zend\\ServiceManager\\ServiceLocatorInterface',
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
          1 => 'WebinoDraw\\Instructions\\InstructionsInterface',
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
