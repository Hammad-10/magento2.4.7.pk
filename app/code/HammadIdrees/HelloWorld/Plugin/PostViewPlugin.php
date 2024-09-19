<?php

namespace HammadIdrees\HelloWorld\Plugin;

class PostViewPlugin
{

    public function afterGetPostData(\HammadIdrees\HelloWorld\Block\PostView $subject, $result)
    {

//        echo '<pre>';
//        print_r($result);  // Print the complete structure of the object
//        echo '</pre>';

            $customer_id = $result->getData('customer_id');
            $title = $result->getData('title');
            $title .= ' ( '. $customer_id.' )';  // Modifying the title by appending text
            $result->setData('title', $title);  // Setting the modified title back

        return $result;
    }

}
