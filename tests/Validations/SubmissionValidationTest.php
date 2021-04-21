<?php

namespace Tests\Validations;

use App\Repositories\MySQLUserRepository;
use App\Requests\SubmissionRequest;
use App\Validations\SubmissionError;
use App\Validations\SubmissionValidation;
use PHPUnit\Framework\TestCase;

class SubmissionValidationTest extends TestCase
{
    public function testValidateSubmission(): void
    {
        $errorMessages = new SubmissionError();
        $validator = new SubmissionValidation(new MySQLUserRepository(), $errorMessages);

        $this->assertTrue($validator->validateSubmission(new SubmissionRequest(
            'Lilly',
            'lilly',
            'lovely'
        )));
    }

    public function testNameError(): void
    {
        $errorMessages = new SubmissionError();
        $validator = new SubmissionValidation(new MySQLUserRepository(), $errorMessages);
        $validator->validateSubmission(new SubmissionRequest('Lilly', 'lilly', 'lovely'));
        $this->assertTrue(strlen($validator->getNameError()) === 0);
    }

    public function testPasswordError(): void
    {
        $errorMessages = new SubmissionError();
        $validator = new SubmissionValidation(new MySQLUserRepository(), $errorMessages);
        $validator->validateSubmission(new SubmissionRequest('Lilly', 'lilly', 'lovely'));
        $this->assertTrue(strlen($validator->getPasswordError()) === 0);

        $validator->validateSubmission(new SubmissionRequest('Lilly', 'billy', 'lovely'));
        $this->assertFalse(strlen($validator->getPasswordError()) === 0);
    }

    public function testPersonalityError(): void
    {
        $errorMessages = new SubmissionError();
        $validator = new SubmissionValidation(new MySQLUserRepository(), $errorMessages);
        $validator->validateSubmission(new SubmissionRequest('Lilly', 'lilly', 'lovely'));
        $this->assertTrue(strlen($validator->getPersonalityError()) === 0);

        $validator->validateSubmission(new SubmissionRequest(
            'Lilly',
            'lilly',
            str_repeat('lovely', 256)));
        $this->assertFalse(strlen($validator->getPasswordError()) > 0);
    }
}