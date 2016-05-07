<?php

/* index4.twig */
class __TwigTemplate_56ae3db6a50b0a4afe16dea792cafe70897f52671bd38fca018324984ea64e5a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("shared_index4.twig", "index4.twig", 1);
        $this->blocks = array(
            'shared' => array($this, 'block_shared'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "shared_index4.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_shared($context, array $blocks = array())
    {
        echo "4";
    }

    public function getTemplateName()
    {
        return "index4.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 2,  11 => 1,);
    }
}
/* {% extends "shared_index4.twig" %}*/
/* {% block shared %}4{% endblock %}*/
