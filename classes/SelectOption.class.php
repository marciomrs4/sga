<?php

/**
 * Class
 * @package Form\SelectOption
 * @name SelectOption
 * @author Márcio Ramos <marciomrs4@gmail.com>
 * @license Creative Common
 * @version 1.0.0
 * @since 2015-06
 */

class SelectOption
{

    /**
     * @var PDOStatement
     *
     */
    private $stmt;

    /**
     * @var String
     */
    private $selectName;

    private $class;

    /**
     * @var bool
     */
    private $isNewOption = false;

    /**
     * @var String
     */
    private $value;

    /**
     * @var String
     */
    private $frase;

    /**
     * @var mixed
     */
    private $valor;

    /**
     * require
     */
    private $require;


    /**
     * @param $frase, $valor
     * @throws not
     * @name setOptionEmpty
     * @return SelectOption
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    public function setOptionEmpty($frase, $valor = null)
    {
        $this->isNewOption = true;
        $this->frase =$frase;
        $this->valor = $valor;
        return $this;
    }

    /**
     * @param $selectName
     * @throws not
     * @name setSelectName
     * @return SelectOption
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    public function setSelectName($selectName)
    {
        $this->selectName = $selectName;
        return $this;
    }

    /**
     * @param $class
     * @throws not
     * @name setClass
     * @return SelectOption
     * @author Márcio Ramos
     * @version 1.1.0
     * @since 2015-06
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @param PDOStatement
     * @throws not
     * @name setStmt
     * @return SelectOption
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    public function setStmt($stmt)
    {
        $this->stmt = $stmt;
        return $this;
    }

    /**
     * @param $value
     * @throws not
     * @name setOptionEmpty
     * @return SelectOption
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    public function setSelectedItem($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param $option
     * @throws not
     * @name selectedItem
     * @return selected="selected"
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    private function selectedItem($option)
    {
        if($this->value == $option)
        {
            return('selected="selected"');
        }
    }

    /**
     * @throws not
     * @name listOption
     * @return Campo Select
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    public function listOption()
    {
        echo '<select name="' . $this->selectName . '" class="'. $this->class .'" '.$this->require.'>';

        $this->optionEmpty();

        foreach ($this->stmt as $linha):

            echo '<option value="', $linha['0'], '"' .
                $this->selectedItem($linha['0']) . '>',
            $linha['1'],
            '</option>';
        endforeach;
        echo('</select>');
    }

    /**
     * @throws not
     * @name optionEmpty
     * @return Option Vazio
     * @author Márcio Ramos
     * @version 1.0.0
     * @since 2015-06
     */
    private function optionEmpty()
    {
        if($this->isNewOption) {
            echo '<option value="', $this->valor, '">',
            $this->frase,
            '</option>';
        }
    }

    public function isRequire($true=false)
    {
        if($true){
            $this->require = 'required';
        }
        return $this;
    }

}