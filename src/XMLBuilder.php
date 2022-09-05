<?php

/**
 * Classe para construir XML dado um array
 *
 * @author Rafael Morais <rafahgmorais@gmail.com>
 * @package BoletosOnline
 */

namespace BoletosOnline;

use DOMDocument;
use DOMElement;

class XMLBuilder extends DOMDocument
{
    /**
     * Converte um array para XML
     * @param array $array
     * @param DOMElement $domElement
     */
    public function convertArrayToXml($array, DOMElement $domElement = null)
    {
        $domElement = is_null($domElement) ? $this : $domElement;

        if (is_array($array)) {
            foreach ($array as $index => $mixedElement) {
                //Descontos será adicionado depois
                if ($index == 'DESCONTOS') {
                    continue;
                } else {
                    if (is_int($index)) {
                        $node = $domElement;
                    } else {
                        $node = $this->createElement($index);
                        $domElement->appendChild($node);
                    }
                    $this->convertArrayToXml($mixedElement, $node);
                }
            }
        } else {
            $domElement->appendChild($this->createTextNode($array));
        }
    }
	/**
	 * Appends nodes after the last child node
	 * Appends one or many `nodes` to the list of children after the last child node.
	 *
	 * @param \DOMNode|null|string $nodes The nodes to append.
	 */
	function append( /*...$nodes*/ ) {
	}
	
	/**
	 * Prepends nodes before the first child node
	 * Prepends one or many `nodes` to the list of children before the first child node.
	 *
	 * @param \DOMNode|null|string $nodes The nodes to prepend.
	 */
	function prepend( /*...$nodes*/ ) {
	}
}
