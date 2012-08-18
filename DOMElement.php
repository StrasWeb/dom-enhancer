<?php 
/**
 * NewDOMElement class
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
 * DOMElement class extended with an useful addElement function
 *
 * PHP Version 5.3.6
 * 
 * @category Class
 * @package  DOMenhancer
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     https://code.google.com/p/dom-enhancer/
 */
class DOMenhancer_DOMElement extends DOMElement
{
    /**
     * Function to easily add a node to another node
     * without having to use createElement + setAttribute + appendChild
     * 
     * @param string $tag        The type of element to add
     * @param string $value      The value (text content) of the node
     * @param array  $attributes An associative array 
     *                           with a list of attributes and their values
     * @param bool   $first      Add the element before the other children?
     * 
     * @return NewDOMElement
     * */
    function addElement($tag, $value=null, $attributes=array(), $first=false)
    {
        $dom=$this->ownerDocument;
        $this->$tag=$dom->createElement($tag);
        if (isset($value)) {    
            $this->$tag->nodeValue=$value;
        }
        foreach ($attributes as $attr => $value) {
            if (!empty($value)) {
                $this->$tag->setAttribute($attr, $value);
                if ($attr=="id") {
                    $this->$tag->setIdAttribute("id", true);
                }
            }
        }
        if ($first) {
            $this->insertBefore($this->$tag, $this->firstChild);
        } else {
            $this->appendChild($this->$tag);
        }
        return($this->$tag);
    }   
    
    /**
     * Add <span>&nbsp;</span>
     * 
     * @return void
     * */
    function addSpace()
    {
        $this->addElement("span", "&nbsp;");
    }
    
    /**
     * Add an <input>
     * 
     * @param string $label Label
     * @param string $type  Type
     * @param string $id    id attribute (also used for class)
     * @param string $name  name attribute
     * @param string $value Value
     * @param bool   $focus Autofocus
     * 
     * @return void
     * */
    function addInput($label, $type, $id, $name, $value, $focus=false)
    {
        if ($type=="submit") {
            $value=$label;
        } else {
            $this->addElement("label", $label, array("for"=>$id));
            $this->addSpace();
        }
        if ($focus) {
            $focus="autofocus";
        }
        $this->addElement(
            "input", null, array(
                "id"=>$id, "name"=>$name,"type"=>$type,
                "value"=>$value, "class"=>$id, "autofocus"=>$focus
            )
        );
    }
    
    /**
     * Add a <form>
     * 
     * @param string $action       Action of the form
     * @param array  $inputs       <input>s to add to the form
     * @param string $method       Method (GET or POST)
     * @param bool   $addSubmitBtn Add a submit button?
     * 
     * @return void
     * */
    function addForm($action, $inputs, $method="GET", $addSubmitBtn=true)
    {
        $form=$this->addElement(
            "form", null, array("action"=>$action, "method"=>$method)
        );
        if (isset($inputs["name"])) {
            $form->addInput(
                $inputs["label"], $inputs["type"], $inputs["id"],
                $inputs["name"], $inputs["value"], $inputs["focus"]
            );
        } else {
            foreach ($inputs as $input) {
                $form->addInput(
                    $input["label"], $input["type"], $input["id"],
                    $input["name"], $input["value"], $input["focus"]
                );
            }
        }
        if ($addSubmitBtn) {
            $form->addInput(null, "submit");
        }
    }
    
    
    /**
     * Add HTML inside an element
     * 
     * @param string $html HTML
     * 
     * @return void
     * */
    function addHTML($html)
    {
        $this->content
            =$this->ownerDocument->createDocumentFragment();
        $this->content
            ->appendXML(stripslashes($html));
        $this
            ->appendChild(
                $this->content
            );
    }
    
}
?>
