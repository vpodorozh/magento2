<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ConfigurableProduct\Model\ResourceModel\Product;

use Magento\Catalog\Model\ResourceModel\Product\LinkedProductSelectBuilderInterface;

/**
 * A decorator for a linked product select builder.
 *
 * Extends functionality of the linked product select builder to allow perform
 * some additional processing of built Select objects.
 */
class LinkedProductSelectBuilder implements LinkedProductSelectBuilderInterface
{
    /**
     * @var BaseSelectProcessorInterface
     */
    private $baseSelectProcessor;

    /**
     * @var LinkedProductSelectBuilderInterface
     */
    private $linkedProductSelectBuilder;

    /**
     * @param BaseSelectProcessorInterface $baseSelectProcessor
     * @param LinkedProductSelectBuilderInterface $linkedProductSelectBuilder
     */
    public function __construct(
        BaseSelectProcessorInterface $baseSelectProcessor,
        LinkedProductSelectBuilderInterface $linkedProductSelectBuilder
    ) {
        $this->baseSelectProcessor = $baseSelectProcessor;
        $this->linkedProductSelectBuilder = $linkedProductSelectBuilder;
    }

    /**
     * @inheritdoc
     */
    public function build($productId): array
    {
        $selects = $this->linkedProductSelectBuilder->build($productId);

        foreach ($selects as $select) {
            $this->baseSelectProcessor->process($select, $productId);
        }

        return $selects;
    }
}
