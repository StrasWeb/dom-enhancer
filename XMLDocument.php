<?php
/**
 * XMLDocument class
 *
 * PHP Version 5.3.6
 * 
 * @category Class
 * @package  DOMenhancer
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     https://code.google.com/p/dom-enhancer/
 */
 /**
 * Class used to create DOM
 *
 * PHP Version 5.3.6
 * 
 * @category Class
 * @package  DOMenhancer
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     https://code.google.com/p/dom-enhancer/
 */
class DOMenhancer_XMLDocument
{
    /**
     * Creates a new document with a DOM
     * 
     * @param string $title  Content of the <title> tag
     * @param bool   $addCSS Add <link rel="stylesheet" href="style.css" /> in <head>
     * 
     * @return void
     * */
    function __construct($title="", $addCSS=false)
    {
        include_once __DIR__."/DOMElement.php";
        include_once __DIR__."/Error.php";
        header("Content-type: text/html;charset=utf-8");
        $this->DOMimpl=new DOMImplementation();
        $doctype=$this->DOMimpl->createDocumentType('html');
        $this->DOM=$this->DOMimpl->createDocument(
            "http://www.w3.org/1999/xhtml", "html", $doctype
        );
        $this->DOM->registerNodeClass('DOMElement', 'DOMenhancer_DOMElement');
        $this->DOM->html=$this->DOM->documentElement;
        $this->DOM->head=$this->DOM->html->head=$this->DOM->createElement("head");
        if (!empty($title)) {
            $this->DOM->head->addElement("title", $title);
        }
        $this->DOM->body=$this->DOM->html->body=$this->DOM->createElement("body");
        $this->DOM->html->appendChild($this->DOM->html->head);
        $this->DOM->html->appendChild($this->DOM->html->body);
        if ($addCSS) {
            $this->DOM->head->addElement(
                "link", null, array("rel"=>"stylesheet", "href"=>"style.css")
            );
        }
    }
    
    /**
     * Display the HTML
     * 
     * @return void
     * */
    function display()
    {
        echo $this->DOM->saveHTML();
    }
}
