<?php
namespace Home\Practice\Block;

use Magento\Framework\View\Element\Template;


/**
 * @noinspection PhpUnused
 */
class Practice extends Template
{
    /**
     * @noinspection PhpUnused
     */
    public function getHelloWorldTxt():string
    {
        return 'Hello World from Block!';
    }

    public function printAdminName():string
    {
        return 'Hammad Idrees';
    }

    public function showImage()
    {

        return 'https://www.zameen.com/blog/wp-content/uploads/2020/02/Vitrified-Tiles-Pros-and-Cons-A-20-02-1024x640.jpg';
    }
}