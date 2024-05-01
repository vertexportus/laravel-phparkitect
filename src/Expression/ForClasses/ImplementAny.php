<?php

namespace VertexPortus\LaravelArkitect\Expression\ForClasses;

use Arkitect\Analyzer\ClassDescription;
use Arkitect\Expression\Description;
use Arkitect\Expression\Expression;
use Arkitect\Rules\Violation;
use Arkitect\Rules\ViolationMessage;
use Arkitect\Rules\Violations;

class ImplementAny implements Expression
{
    /**
     * @inheritDoc
     */
    public function describe(ClassDescription $theClass, string $because): Description {
        return new Description("should implement a contract", $because);
    }

    /**
     * @inheritDoc
     */
    public function evaluate(ClassDescription $theClass, Violations $violations, string $because): void {
        if (class_implements($theClass->getFQCN())) {
            return;
        }

        $violation = Violation::create(
            $theClass->getFQCN(),
            ViolationMessage::selfExplanatory($this->describe($theClass, $because))
        );
        $violations->add($violation);
    }
}
