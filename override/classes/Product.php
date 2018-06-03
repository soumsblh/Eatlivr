<?php
class Product extends ProductCore
{
    public function getComments($limit_start, $limit_end = false)
    {
        return eatlivrComment::getProductComments($this->id, $limit_start, $limit_end);
    }
}
