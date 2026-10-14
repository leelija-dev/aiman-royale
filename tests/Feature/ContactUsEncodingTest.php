<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactUsEncodingTest extends TestCase
{
    public function test_rejects_invalid_utf8_in_contact_message(): void
    {
        $invalidUtf8 = "\xED\xA0\xBD\xED\xB4\x8D";

        $response = $this->from('/contact-us')->post(
            route('contact-us.store'),
            [
                'name' => 'Test Customer',
                'email' => 'test@example.com',
                'mobile' => '9876543210',
                'subject' => 'General Inquiry',
                'message' => $invalidUtf8,
            ]
        );

        $response->assertRedirect('/contact-us');
        $response->assertSessionHasErrors('message');
    }
}
