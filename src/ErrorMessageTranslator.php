<?php

namespace Yuloh\JsonGuard\Illuminate;

use League\JsonGuard\ValidationError;
use Symfony\Component\Translation\TranslatorInterface;

class ErrorMessageTranslator
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Return the translated message for the error.
     *
     * @param ValidationError $error
     *
     * @return string
     */
    public function translate(ValidationError $error) : string
    {
        return $this->translator->trans(
            "json-guard::validation.{$error->getKeyword()}",
            $error->getContext()
        );
    }
}
