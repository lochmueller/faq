<?php

declare(strict_types = 1);

namespace HDNET\Faq\Service;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SchemaService
{
    public function addSchemaOrgHeader(iterable $questions): void
    {
        $additionalHeaderData = '
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "FAQPage",
            "mainEntity": [';
        foreach ($questions as $question) {
            $additionalHeaderData .= str_replace([
                'QUESTION_TEXT',
                'CREATED',
                'ANSWER_TEXT',
            ],
                [
                    htmlentities($question->getTitle()),
                    $question->getCrdate()->format('Y-m-d H:i:s'),
                    htmlentities(\strip_tags($question->getAnswer())),
                ],
                '{
                "@type": "Question",
                "name": "QUESTION_TEXT",
                "dateCreated": "CREATED",
                "acceptedAnswer": {
                    "@type": "answer",
                    "text": "ANSWER_TEXT",
                    "dateCreated": "CREATED"
                }
            },');
        }
        $additionalHeaderData = mb_substr($additionalHeaderData, 0, -1);
        $additionalHeaderData .= '
            ]
        }
        </script>';

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addHeaderData($additionalHeaderData);
    }
}
