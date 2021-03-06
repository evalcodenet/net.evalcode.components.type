<?php


namespace Components;


  /**
   * Collection_Mutable_Set
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage collection.mutable
   *
   * @author evalcode.net
   */
  class Collection_Mutable_Set extends Collection_Set implements Collection_Mutable
  {
    // OVERRIDES
    /**
     * @see Collection_Mutable::arrayValue() Collection_Mutable::arrayValue()
     */
    public function arrayValue()
    {
      return $this->m_elements;
    }

    /**
     * @see Components\Object::__toString() Components\Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%s@%s{count: %d, position: %d}',
        __CLASS__,
        $this->hashCode(),
        $this->m_count,
        $this->m_position
      );
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see Collection_Mutable::add() Collection_Mutable::add()
     */
    public function add($element_)
    {
      $this->m_count=array_push($this->m_elements, $element);
    }

    /**
     * @see Collection_Mutable::addAll() Collection_Mutable::addAll()
     */
    public function addAll(Collection $elements_)
    {
      foreach($elements_->arrayValue() as $element)
        $this->add($element);
    }

    /**
     * @see Collection_Mutable::remove() Collection_Mutable::remove()
     */
    public function remove($element_=null)
    {
      $removed=$element_;

      $elements=[];

      if(null===$element_)
      {
        $removed=$elements[$this->m_position];

        $elements=array_merge(
          array_slice($this->m_elements, 0, $this->m_position-1),
          array_slice($this->m_elements, $this->m_position)
        );
      }
      else
      {
        foreach($this->m_elements as $element)
        {
          if($element!==$element_)
            array_push($elements, $element);
        }
      }

      $this->m_elements=$elements;
      $this->m_count=count($elements);

      if(false===isset($this->m_elements[$this->m_position]))
        $this->previous();

      return $removed;
    }

    /**
     * @see Collection_Mutable::removeAll() Collection_Mutable::removeAll()
     */
    public function removeAll(Collection $elements_)
    {
      $elements=[];
      foreach($this->m_elements as $element)
      {
        if(false===$elements_->contains($element))
          array_push($elements, $element);
      }

      $this->m_elements=$elements;
      $this->m_count=count($elements);

      if(false===isset($this->m_elements[$this->m_position]))
        $this->previous();
    }

    /**
     * @see Collection_Mutable::retainAll() Collection_Mutable::retainAll()
     */
    public function retainAll(Collection $elements_)
    {
      $elements=[];
      foreach($this->m_elements as $element)
      {
        if($elements_->contains($element))
          array_push($elements, $element);
      }

      $this->m_elements=$elements;
      $this->m_count=count($elements);

      if(false===isset($this->m_elements[$this->m_position]))
        $this->previous();
    }

    /**
     * @see Collection_Mutable::clear() Collection_Mutable::clear()
     */
    public function clear()
    {
      $this->m_elements=[];
      $this->m_position=0;
      $this->m_count=0;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    public function previous()
    {
      while(0<$this->m_position)
      {
        if(isset($this->m_elements[--$this->m_position]))
          break;
      }
    }
    //--------------------------------------------------------------------------
  }
?>
