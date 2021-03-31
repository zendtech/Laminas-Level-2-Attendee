<?php
/**
 * QuestionFormInputFilterFactory
 */

namespace Login\Form\Factory;
use Interop\Container\ContainerInterface;
use Login\Form\{
    QuestionFormInputFilter,
    QuestionForm
};

class QuestionFormInputFilterFactory implements FactoryInterface{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new QuestionForm(
            new QuestionFormInputFilter()
        );
    }
}