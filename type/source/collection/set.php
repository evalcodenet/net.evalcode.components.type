<?php


namespace Components;


  /**
   * Collection_Set
   *
   * @package net.evalcode.components
   * @subpackage type.collection
   *
   * @author evalcode.net
   */
  class Collection_Set implements Collection
  {
    // CONSTRUCTION
    protected function __construct(array $elements_)
    {
      $this->m_elements=$elements_;
      $this->m_count=count($this->m_elements);
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param Collection $elements_
     *
     * @return Collection_Set
     */
    public static function of(Collection $elements_)
    {
      return new static($elements_->arrayValue());
    }

    /**
     * @param array|mixed $elements_
     *
     * @return Collection_Set
     */
    public static function wrap(array $elements_)
    {
      return new static($elements_);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Collection::contains()
     */
    public function contains($element_)
    {
      return Arrays::containsValue($this->m_elements, $element_, Arrays::UNSORTED);
    }

    /**
     * @see Collection::containsArray()
     */
    public function containsArray(array $elements_)
    {
      // TODO Implement Arrays::containsValues(..)
      return Arrays::containsValues($this->m_elements, $elements_, Arrays::UNSORTED);
    }

    /**
     * @see Collection::containsCollection()
     */
    public function containsCollection(Collection $elements_)
    {
      // TODO Implement Arrays::containsValues(..)
      return Arrays::containsValues($this->m_elements, $elements_->arrayValue(), Arrays::UNSORTED);
    }

    /**
     * @see Countable::count()
     */
    public function count()
    {
      return $this->m_count;
    }

    /**
     * @see Iterator::current()
     */
    public function current()
    {
      return $this->m_element[-1<$this->m_position?$this->m_position:0];
    }

    /**
     * @see Iterator::key()
     */
    public function key()
    {
      return -1<$this->m_position?$this->m_position:0;
    }

    /**
     * @see Iterator::hasNext()
     */
    public function hasNext()
    {
      return $this->m_count>$this->m_position;
    }

    /**
     * @see Iterator::hasPrevious()
     */
    public function hasPrevious()
    {
      return -1<$this->m_position;
    }

    /**
     * @see Iterator::next()
     */
    public function next()
    {
      if($this->m_count>$this->m_position)
        return $this->m_elements[++$this->m_position];

      throw new Exception_IllegalState('collection/set', 'End of collection reached.');
    }

    /**
     * @see Iterator::previous()
     */
    public function previous()
    {
      if(-1<$this->m_position)
        return $this->m_elements[--$this->m_position];

      throw new Exception_IllegalState('collection/set', 'Beginning of collection reached.');
    }

    /**
     * @see Iterator::rewind()
     */
    public function rewind()
    {
      $this->m_position=-1;
    }

    /**
     * @see Iterator::valid()
     */
    public function valid()
    {
      return $this->m_position<$this->m_count;
    }

    /**
     * @see Collection::isEmpty()
     */
    public function isEmpty()
    {
      return 0===$this->m_count;
    }

    /**
     * @see Collection::arrayValue()
     */
    public function arrayValue()
    {
      return array_values($this->m_elements);
    }

    /**
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return spl_object_hash($this);
    }

    /**
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * @see Components.Object::__toString()
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


    // IMPLEMENTATION
    /**
     * Internal storage array of this collection.
     *
     * @var mixed|array
     */
    protected $m_elements=array();
    /**
     * Internal pointer for iterating this collection.
     *
     * @var integer
     */
    protected $m_position=-1;
    /**
     * Amount of elements in this collection.
     *
     * @var integer
     */
    protected $m_count;
    //--------------------------------------------------------------------------
  }
?>
