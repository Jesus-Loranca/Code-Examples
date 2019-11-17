<?php

use Substrakt\SEO\Social;

class SocialTests
extends SEOTestCase
{
   /**
    *
    */
    public function testSocialClassExists()
    {
        $this->assertTrue(class_exists('\Substrakt\SEO\Social'));
    }

   /**
    *
    */
    public function testDescriptiontMethodExists()
    {
        $this->assertTrue(method_exists('\Substrakt\SEO\Social', 'description'));
    }

   /**
    * @dataProvider descriptionProvider
    */
    public function testDescriptionMethodReturnsDataDescription($expected)
    {
        $social = new Social([], []);
        $social->data = (object) [];
        $social->data->description = $expected;

        // This mocks the get_field function for the Site method.
        $this->mockSanitizeTextField([
            'args'   => [$expected],
            'return' => $expected,
        ]);

        $this->assertEquals($expected, $social->description());
    }

   /**
    * @dataProvider descriptionProvider
    */
    public function testDescriptionMethodReturnsMetaDescription($expected)
    {
        $social = new Social([], []);
        $social->data = (object) [];
        $social->meta = (object) [];
        $social->data->description = '';
        $social->meta->description = $expected;

        // This mocks the get_field function for the Site method.
        $this->mockSanitizeTextField([
            'args'   => [$expected],
            'return' => $expected,
        ]);

        $this->assertEquals($expected, $social->description());
    }

   /**
    *
    */
    public function testDescriptionMethodReturnsEmptyStringByDefault()
    {
        $social = new Social([], []);
        $social->data = $social->meta = (object) [];
        $social->data->description = $social->meta->description  = '';

        $this->assertEquals('', $social->description());
    }

   /**
    *
    */
    public function testImagetMethodExists()
    {
        $this->assertTrue(method_exists('\Substrakt\SEO\Social', 'image'));
    }

   /**
    * @dataProvider imageURLProvider
    */
    public function testImageMethodReturnsMetaImage($expected)
    {
        $social = new Social([], []);
        $social->meta = (object) [];
        $social->meta->image = $expected;

        $this->assertEquals($expected, $social->image());
    }

   /**
    * @dataProvider imageArrayProvider
    */
    public function testImageMethodReturnsDataImage($expected)
    {
        $social = new Social([], []);
        $social->meta = (object) [];
        $social->data = (object) [];
        $social->meta->image = '';
        $social->data->image = $expected;

        WP_Mock::wpFunction('wp_get_attachment_image_src', [
            'args'   => [$social->data->image['ID'], 'large'],
            'return' => $expected,
        ]);

        $this->assertEquals($expected['ID'], $social->image());
    }

   /**
    *
    */
    public function testImageMethodReturnsEmptyStringByDefault()
    {
        $social = new Social([], []);
        $social->data = $social->meta = (object) [];
        $social->data->image = $social->meta->image  = '';

        $this->assertEquals('', $social->image());
    }

   /**
    *
    */
    public function testTitletMethodExists()
    {
        $this->assertTrue(method_exists('\Substrakt\SEO\Social', 'title'));
    }

   /**
    * @dataProvider titleProvider
    */
    public function testTitleMethodReturnsDataTitle($expected)
    {
        $social = new Social([], []);
        $social->data = (object) [];
        $social->data->title = $expected;

        // This mocks the get_field function for the Title method.
        $this->mockSanitizeTextField([
            'args'   => [$expected],
            'return' => $expected,
        ]);

        $this->assertEquals($expected, $social->title());
    }

   /**
    * @dataProvider titleProvider
    */
    public function testTitleMethodReturnsMetaTitle($expected)
    {
        $social = new Social([], []);
        $social->data = (object) [];
        $social->meta = (object) [];
        $social->data->title = '';
        $social->meta->title = $expected;

        // This mocks the get_field function for the Title method.
        $this->mockSanitizeTextField([
            'args'   => [$expected],
            'return' => $expected,
        ]);

        $this->assertEquals($expected, $social->title());
    }

   /**
    *
    */
    public function testTitleMethodReturnsEmptyStringByDefault()
    {
        $social = new Social([], []);
        $social->data = $social->meta = (object) [];
        $social->data->title = $social->meta->title  = '';

        $this->assertEquals('', $social->title());
    }

   /**
    * Wrapper for WP_Mock::wpFunction('sanitize_text_field',)
    * @param array $params
    * @return void
    */
    private function mockSanitizeTextField(array $params):void
    {
       WP_Mock::wpFunction('sanitize_text_field', $params);
    }
}
