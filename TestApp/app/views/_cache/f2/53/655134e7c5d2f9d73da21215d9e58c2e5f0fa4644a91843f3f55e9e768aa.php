<?php

/* index4.twig */
class __TwigTemplate_f253655134e7c5d2f9d73da21215d9e58c2e5f0fa4644a91843f3f55e9e768aa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("shared_index4.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

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
        return array (  36 => 2,  11 => 1,);
    }
}
