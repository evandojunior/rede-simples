<?php

namespace Project\Core\Helper;

/**
 * Class XML2ArrayHelper
 * @package Project\Core\Helper
 */
class XML2ArrayHelper
{
    const NAME_ATTRIBUTES = 'attributes';

    const NAME_CONTENT = 'content';

    const NAME_ROOT = 'root';
    /**
     * Convert DOMDocument->documentElement to array
     *
     * @param \DOMElement $documentElement
     * @return array
     */
    public static function DOMDocumentToArray($documentElement) {
        $return = array();
        switch ($documentElement->nodeType) {

            case XML_CDATA_SECTION_NODE:
                $return = trim($documentElement->textContent);
                break;
            case XML_TEXT_NODE:
                $return = trim($documentElement->textContent);
                break;

            case XML_ELEMENT_NODE:
                for ($count=0, $childNodeLength=$documentElement->childNodes->length; $count<$childNodeLength; $count++) {
                    $child = $documentElement->childNodes->item($count);
                    $childValue = self::DOMDocumentToArray($child);
                    if(isset($child->tagName)) {
                        $tagName = $child->tagName;
                        if(!isset($return[$tagName])) {
                            $return[$tagName] = array();
                        }
                        $return[$tagName][] = $childValue;
                    }
                    elseif($childValue || $childValue === '0') {
                        $return = (string) $childValue;
                    }
                }
                if($documentElement->attributes->length && !is_array($return)) {
                    $return = array(self::NAME_CONTENT=>$return);
                }

                if(is_array($return))
                {
                    if($documentElement->attributes->length)
                    {
                        $attributes = array();
                        foreach($documentElement->attributes as $attrName => $attrNode)
                        {
                            $attributes[$attrName] = (string) $attrNode->value;
                        }
                        $return[self::NAME_ATTRIBUTES] = $attributes;
                    }
                    foreach ($return as $key => $value)
                    {
                        if(is_array($value) && count($value)==1 && $key!=self::NAME_ATTRIBUTES)
                        {
                            $return[$key] = $value[0];
                        }
                    }
                }
                break;
        }
        return $return;
    }
}
