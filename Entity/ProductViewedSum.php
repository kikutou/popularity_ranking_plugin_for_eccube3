<?php
namespace Plugin\PopularityRanking\Entity;

class ProductViewedSum extends \Eccube\Entity\AbstractEntity
{   
    private $id;
    
    private $Product;

    private $viewed_sum;

    /**
     * @var \DateTime
     */
    private $create_date;

    /**
     * @var \DateTime
     */
    private $update_date;

    /**
     * @return mixed
     */
    public function getViewedSum()
    {
        return $this->viewed_sum;
    }

    /**
     * @param mixed $viewed_sum
     */
    public function setViewedSum($viewed_sum)
    {
        $this->viewed_sum = $viewed_sum;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * @param mixed $Product
     */
    public function setProduct($Product)
    {
        $this->Product = $Product;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param \DateTime $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * @param \DateTime $update_date
     */
    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;
    }





    public function getId()
    {
        return $this->id;
    }



    
}