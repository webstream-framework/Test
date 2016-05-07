<?php

/* shared_index4.twig */
class __TwigTemplate_d10b179b26feeee9ec1242e2c69fec622659d2e7771ab7aff845406ec39f8567 extends Twig_Template
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
/* index{% block shared %}{% endblock %}*/
