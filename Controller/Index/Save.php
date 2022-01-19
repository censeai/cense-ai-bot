<?php
namespace Censeaiinc\Cense\Controller\Index;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $resultFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->resultFactory = $resultFactory;
        return parent::__construct($context);
    }

    public function execute()
    {

       $productId = $this->getRequest()->getParam('s_id');
       $product_ids = explode(',', $productId );
       $count       = count( $product_ids );
       $number      = 0;
       if(count($product_ids)>0)
       {
        
    
        foreach ( $product_ids as $product_id ) {
            $obj = \Magento\Framework\App\ObjectManager::getInstance();
            
            $product = $obj->create('\Magento\Catalog\Model\Product')->load($product_id);

            $cart = $obj->create('Magento\Checkout\Model\Cart');    
            $params = array();      
            $options = array();
            $params['qty'] = 1;
            $params['product'] = $product_id;

            /*foreach ($product->getOptions() as $o) 
            {       
                foreach ($o->getValues() as $value) 
                {
                    $options[$value['option_id']] = $value['option_type_id'];

                }           
            }*/

            //$params['options'] = $options;
            $cart->addProduct($product_id, $params);
            $cart->save();
        }
        $storeManager = $obj->get('\Magento\Store\Model\StoreManagerInterface');
        $baseURL=$storeManager->getStore()->getBaseUrl();

        $cartUrl=$baseURL.'checkout/cart/';


        echo "<script> url = '".$cartUrl."'; window.location.replace(url);</script>";
        exit;

    }

}
}