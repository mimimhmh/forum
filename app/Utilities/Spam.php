<?php

namespace App\Utilities;

class Spam
{
    /**
     * @param $body
     * @return bool
     */
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    /**
     * @param $body
     * @throws \Exception
     */
    protected function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'Yahoo Customer Support',
        ];

        foreach ($invalidKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Spam detected in your replies.');
            }
        }
    }
}