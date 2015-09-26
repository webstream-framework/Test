<?php

/* index2.twig */
class __TwigTemplate_a148dabc74da17b6696c1d54459f8a85eb97f0abf624e740dd2ce6f9058ed51e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["model"]) ? $context["model"] : null), "service1", array()), "html", null, true);
    }

    public function getTemplateName()
    {
        return "index2.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
