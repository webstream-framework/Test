<?php

/* index2.twig */
class __TwigTemplate_aa6cd7b12c8d16c5874a9dc8312553c688d22d85cbd163abb49211693cf52333 extends Twig_Template
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
/* {{ model.service1 }}*/
