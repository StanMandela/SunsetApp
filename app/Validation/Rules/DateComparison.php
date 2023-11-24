<?php

namespace App\Validation\Rules;

use CodeIgniter\Validation\StrictRules\Rules;

class DateComparison extends Rules
{
    public function __construct(string $format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    public function check($value): bool
    {
        $createdOn = $this->validation->getRule('greater_than')->getParameters()[0];

        // Parse dates
        $createdOnDate = \DateTime::createFromFormat($this->format, $createdOn);
        $updatedOnDate = \DateTime::createFromFormat($this->format, $value);

        // Check if updated_on is not smaller than created_on
        return $updatedOnDate >= $createdOnDate;
    }

    public function setParameters(array $parameters): Rule
    {
        return $this;
    }
}
