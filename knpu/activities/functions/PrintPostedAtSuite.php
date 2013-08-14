<?php

use KnpU\ActivityRunner\Assert\AssertSuite;

class PrintPostedAtSuite extends AssertSuite
{
    public function testHasUsedFilter()
    {
        $inputFiles = $this->getActivity()->getInputFiles();
        $input = $inputFiles->get('product.twig');

        // Look for `|date` without caring about spaces.
        $this->assertRegExp('#\|\s*date#', $input,
            'Using the |date filter to convert the date into a string.'
        );

        $this->assertRegexp('#Y-m-d#', $input,
            'Make sure to render the date with a "Y-m-d" format.'
        );

        // Now check that things are in the right spot.
        $postedAts = $this->getCrawler()->filter('.posted-at');

        $this->assertEquals(1, count($postedAts), 'Did you forget to render the date inside an element with a "posted-at" class?');
        $this->assertRegexp("/2013-06-05/", $postedAts->text());
    }
}
