<?php

declare(strict_types = 1);

namespace HDNET\Faq\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('faqCTypeUpdate')]
class FaqCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    public function getTitle(): string
    {
        return 'Migrate FAQ plugins (list_type) to content elements (CType)';
    }

    public function getDescription(): string
    {
        return 'Migrates existing FAQ content elements that are still registered as "list_type" plugins to the corresponding "CType" content elements.';
    }

    /**
     * The "list_type" to "CType" mapping. The plugin signatures did not change,
     * only the way they are registered, so the mapping is an identity.
     *
     * @return array<string, string>
     */
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'faq_faq' => 'faq_faq',
            'faq_faqall' => 'faq_faqall',
            'faq_question' => 'faq_question',
            'faq_faqsinglecategory' => 'faq_faqsinglecategory',
        ];
    }
}
