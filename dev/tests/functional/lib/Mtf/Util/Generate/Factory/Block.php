<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @api
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mtf\Util\Generate\Factory;

/**
 * Class Block
 *
 * Block Factory generator
 *
 */
class Block extends AbstractFactory
{
    protected $type = 'Block';

    /**
     * Collect Items
     */
    protected function generateContent()
    {
        $blocks = $this->collectItems('Block');
        foreach ($blocks as $block) {
            $this->addBlockToFactory($block);
        }
    }

    /**
     * Add Block to content
     *
     * @param array $item
     */
    protected function addBlockToFactory(array $item)
    {
        list($module, $name) = explode('Test\\Block', $item['class']);
        $methodNameSuffix = $module . $name;
        $methodNameSuffix = $this->_toCamelCase($methodNameSuffix);

        $realClass = $this->_resolveClass($item);
        $fallbackComment = $this->_buildFallbackComment($item, '$element');
        $params = "\$element, \$driver = null, \$config = []";

        $this->factoryContent .= "\n    /**\n";
        $this->factoryContent .= "     * @return \\{$item['class']}\n";
        $this->factoryContent .= "     */\n";
        $this->factoryContent .= "    public function get{$methodNameSuffix}({$params})\n";
        $this->factoryContent .= "    {";

        if (!empty($fallbackComment)) {
            $this->factoryContent .= $fallbackComment . "\n";
        } else {
            $this->factoryContent .= "\n";
        }

        $this->factoryContent .= "        return \$this->objectManager->create('{$realClass}', "
            . "array('element' => \$element, 'driver' => \$driver, 'config' => \$config));";
        $this->factoryContent .= "\n    }\n";

        $this->cnt++;
    }
}
