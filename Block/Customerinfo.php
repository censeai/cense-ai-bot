<?php
namespace Censeaiinc\Cense\Block;


 
class Customerinfo  extends \Magento\Framework\View\Element\Template
{
      protected $httpContext;
      protected $_customerSession;

    public function __construct(
     \Magento\Framework\View\Element\Template\Context $context,
     \Magento\Framework\App\Http\Context $httpContext,
     \Magento\Customer\Model\Session $customerSession,
     array $data = []
    ) {
     $this->httpContext = $httpContext;
     $this->_customerSession = $customerSession;
     parent::__construct($context, $data);
    }

    public function getCustomerIsLoggedIn()
    {  
         
      $six_digit_random_number = random_int(100000, 999999);
      $this->_customerSession->setCustomerRandomName($six_digit_random_number);
      return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }


    public function getCustomerEmail()
    {
     $objectManager =  '\Magento\Framework\App\ObjectManager'::getInstance();
     $customerSession = $objectManager->get('Magento\Customer\Model\SessionFactory')->create();

     $customer['id']=$customerSession->getCustomer()->getId();
     $customer['email']=$customerSession->getCustomer()->getEmail();
     
     return json_encode($customer);
    }

    public function getLicenceKey()
    {
     $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
     return $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('censeaiinc/general/licence_key');
    }


    public function getUserName()
    {
      return $this->_customerSession->getCustomerRandomName();
       
    }


}