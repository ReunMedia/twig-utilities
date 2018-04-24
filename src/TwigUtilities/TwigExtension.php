<?php

namespace Reun\TwigUtilities;

use \Twig_Extension;
use \Twig_Filter;
use \Twig_Function;

/**
 * Class based Twig extension that supports Function and Filter classes.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 */
class TwigExtension extends Twig_Extension
{
    use FunctionClassToTwigFunctionTrait;

    /** @var Array List of fully qualified class names to use as functions */
    public $functionClasses = [];

    /** @var Array List of fully qualified class names to use as filters */
    public $filterClasses = [];

    public function __construct($functionClasses = [], $filterClasses = [])
    {
        $this->functionClasses = $functionClasses;
        $this->filterClasses = $filterClasses;
    }

    public function getFunctions()
    {
        return $this->functionClassesToTwigFunctions($this->functionClasses, Twig_Function::class);
    }

    public function getFilters()
    {
        return $this->functionClassesToTwigFunctions($this->filterClasses, Twig_Filter::class);
    }
}
