<?php

namespace AppTest\Unit\Utilities;

use Illuminate\Support\Collection;

use AppTest\BaseCase;
use App\Utilities\Validator\Validator;

class ValidatorTest extends BaseCase
{
    /**
     * @test
     */
    public function validation_failes_with_inputs_missing_values()
    {
        $rules = new Collection([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $input = new Collection([
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ]);

        $validator = new Validator($rules, $input);

        $this->assertFalse(
            $validator->isValid(),
            "Validation returned true with request containing empty inputs"
        );

        $this->assertSame(
            [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required'],
                'password_confirmation' => ['required']
            ],
            $validator->errors,
            "Validation errors differ with empty input"
        );
    }

    /**
     * @test
     */
    public function validation_fails_with_invalid_email()
    {
        $rules = new Collection([
            'email' => 'required|email'
        ]);

        $input = new Collection([
            'email' => 'some string'
        ]);

        $validator = new Validator($rules, $input);

        $this->assertFalse(
            $validator->isValid(),
            "Validation returned true with request containing invalid email address"
        );

        $this->assertSame(
            [
                'email' => ['email']
            ],
            $validator->errors,
            "Validation errors do not match invalid email address"
        );
    }

    /**
     * @test
     */
    public function validation_fails_with_invalid_confirmation_input()
    {
        $rules = new Collection([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $input = new Collection([
            'password' => 'abc',
            'password_confirmation' => 'def'
        ]);

        $validator = new Validator($rules, $input);

        $this->assertFalse(
            $validator->isValid(),
            "Validation returned true with request containing invalid confirmation"
        );

        $this->assertSame(
            [
                'password' => ['confirmed']
            ],
            $validator->errors,
            "Validation errors do not match invalid confirmation"
        );
    }

    /**
     * @test
     */
    public function validation_passes_with_valid_input()
    {
        $rules = new Collection([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $input = new Collection([
            'name' => 'Sebastian Sulinski',
            'email' => 'info@ssdtutorials.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $validator = new Validator($rules, $input);

        $this->assertTrue(
            $validator->isValid(),
            "Validation returned false with request containing valid input"
        );

        $this->assertCount(
            0,
            $validator->errors,
            "Validation errors differ with valid input"
        );
    }
}