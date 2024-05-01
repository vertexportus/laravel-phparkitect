<?php

namespace LaravelArkitect\Expression\ForClasses;

use Arkitect\Analyzer\ClassDescription;
use Arkitect\Expression\Description;
use Arkitect\Expression\Expression;
use Arkitect\Rules\Violation;
use Arkitect\Rules\ViolationMessage;
use Arkitect\Rules\Violations;

class DirectlyOrIndirectlyExtend implements Expression
{
    public function __construct(private string $baseClassName) {}


    /**
     * @inheritDoc
     */
    public function describe(ClassDescription $theClass, string $because): Description {
        return new Description("should extend (even if indirectly) {$this->baseClassName}", $because);
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ClassDescription $theClass, Violations $violations, string $because): void {
        $extends = $theClass->getExtends();
        if (null !== $extends &&
            ($extends->matches($this->baseClassName) || is_subclass_of($theClass->getFQCN(), $this->baseClassName))) {
                return;
        }

        $violation = Violation::create(
            $theClass->getFQCN(),
            ViolationMessage::selfExplanatory($this->describe($theClass, $because))
        );
        $violations->add($violation);
    }
}
