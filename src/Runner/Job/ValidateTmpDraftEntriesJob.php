<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 12/02/19
 * Time: 10.38.
 */

namespace App\Runner\Job;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateTmpDraftEntriesJob extends AbstractDatabaseJob
{
    const KEY_VALIDATOR = 'validator';

    public function getName(): string
    {
        return 'app:job:validate:tmp-draft';
    }

    public function getDescription(): string
    {
        return 'Validating temporary draft entries';
    }

    public function getSteps(): iterable
    {
        // TODO: Implement getSteps() method.
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->getParameters()->set(self::KEY_VALIDATOR, $validator);
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->getParameter(self::KEY_VALIDATOR);
    }
}
