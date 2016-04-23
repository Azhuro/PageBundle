<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace Azhuro\Bundle\PageBundle\Templating\Helper;

use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;
use Sonata\BlockBundle\Templating\Helper\BlockHelper;

class PageHelper
{
    /**
     * @var BlockHelper
     */
    protected $blockHelper;

    /**
     * PageHelper constructor.
     * @param BlockHelper $blockHelper
     */
    public function __construct(BlockHelper $blockHelper)
    {
        $this->blockHelper = $blockHelper;
    }

    /**
     * @param PageInterface $page
     * @return mixed
     */
    public function render(PageInterface $page)
    {
        $content = $page->getContent();

        $pattern = <<<PATTERN
/\{\{\s?(.*?)(?=\}\})\s?\}\}/
PATTERN;

        // Check if {{*}} exists in content
        $count = preg_match_all($pattern, $content, $matches);
        if (!$count) {
            return $content;
        }

        $pattern = <<<PATTERN
/\s*block+\s?\('*(.*?)'*\)+\s*/
PATTERN;

        for ($i = 0; $i < count($matches[1]); $i++) {

            // Check if block(*) exists in content
            preg_match_all($pattern, $matches[1][$i], $blocks);
            foreach ($page->getBlocks() as $block) {
                if (in_array($block->getName(), $blocks[1])) {
                    $content = str_replace($matches[0][$i], $this->blockHelper->render($block), $content);
                }
            }
        }

        return $content;
    }
}