<?php

/* shared_index4.twig */
class __TwigTemplate_c8b7a1450483c5608638b0c35039c4a1c2354de6ebbda01e2a7d1121459963fa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'shared' => array($this, 'block_shared'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "index";
        $this->displayBlock('shared', $context, $blocks);
    }

    public function block_shared($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "shared_index4.twig";
    }

    public function getDebugInfo()
    {
        return array (  20 => 1,);
    }
}
