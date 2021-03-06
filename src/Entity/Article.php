<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
*/
class Article
{
  /**
  * @ORM\Id
  * @ORM\GeneratedValue
  * @ORM\Column(type="integer")
  */
  private $id;
  
  /**
  * @ORM\Column(type="string")
  */
  private $title;
  
  /**
  * @ORM\Column(type="text")
  */
  private $content;
  
  /**
  * @ORM\ManyToOne(targetEntity="App\Entity\User")
  */
  private $author;
  
  /**
  * @ORM\Column(type="datetime")
  */
  private $date;
  
  /**
  * @ORM\ManyToMany(targetEntity="App\Entity\Image", cascade={"persist"})
  */
  private $images;
  
  /**
  * @ORM\Column(type="simple_array", nullable=true)
  */
  private $category;
  
  protected static $categoryParameter = ['documentation' => "Description de l'association", "trend"=>"Mis en avant"];
  
  public function getFormatedCategory()
  {
    $categorys = $this->getCategory();
    $formatedCategory = '';
    foreach($categorys as $category){
      $formatedCategory.= self::$categoryParameter[$category].", ";
    }
    $formatedCategory = substr($formatedCategory, 0, -2);
    return $formatedCategory;
  }
  
  public function __construct() {
    $this->date = new \DateTime();
  }
  /**
  * Get the value of Id
  *
  * @return mixed
  */
  public function getId()
  {
    return $this->id;
  }
  
  /**
  * Set the value of Id
  *
  * @param mixed id
  *
  * @return self
  */
  public function setId($id)
  {
    $this->id = $id;
    
    return $this;
  }
  
  /**
  * Get the value of Title
  *
  * @return mixed
  */
  public function getTitle()
  {
    return $this->title;
  }
  
  /**
  * Set the value of Title
  *
  * @param mixed title
  *
  * @return self
  */
  public function setTitle($title)
  {
    $this->title = $title;
    
    return $this;
  }
  
  /**
  * Get the value of Content
  *
  * @return mixed
  */
  public function getContent()
  {
    return $this->content;
  }
  
  /**
  * Set the value of Content
  *
  * @param mixed content
  *
  * @return self
  */
  public function setContent($content)
  {
    $this->content = $content;
    
    return $this;
  }
  
  /**
  * Get the value of Author
  *
  * @return mixed
  */
  public function getAuthor()
  {
    return $this->author;
  }
  
  /**
  * Set the value of Author
  *
  * @param mixed author
  *
  * @return self
  */
  public function setAuthor($author)
  {
    $this->author = $author;
    
    return $this;
  }
  
  /**
  * Get the value of Date
  *
  * @return mixed
  */
  public function getDate()
  {
    return $this->date;
  }
  
  /**
  * Set the value of Date
  *
  * @param mixed date
  *
  * @return self
  */
  public function setDate($date)
  {
    $this->date = $date;
    
    return $this;
  }
  
  
  /**
  * Get the value of Image
  *
  * @return mixed
  */
  public function getImages()
  {
    return $this->images;
  }
  
  /**
  * Set the value of Image
  *
  * @param mixed image
  *
  * @return self
  */
  public function setImages($images)
  {
    $this->images = $images;
    
    return $this;
  }
  
  
  public function getCategory() {
    return $this->category;
  }
  
  public function setCategory($category) {
    $this->category = $category;
    return $this;
  }
  
  
}
