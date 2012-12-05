<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


    protected function _initMyRouter(){
        
        // Get Front Controller Instance
        $front = Zend_Controller_Front::getInstance();

        // Get Router
        $router = $front->getRouter();
        
        
        $router->addRoute('transaction', 
            new Zend_Controller_Router_Route(
                    '/transaction/:action/:arg1/:arg2/',
                    array(
                            'controller' => 'transaction',
                            'action'     => ':action',
                            'arg1'       => ':arg1',
                            'arg2'       => ':arg2'
                            )
                    )
         );
        
        $router->addRoute('tags', 
            new Zend_Controller_Router_Route(
                    '/tags/:action/:arg1/:arg2/',
                    array(
                            'controller' => 'tags',
                            'action'     => ':action',
                            'arg1'       => ':arg1',
                            'arg2'       => ':arg2'
                            )
                    )
         );
        
        $router->addRoute('category', 
            new Zend_Controller_Router_Route(
                    '/category/:action/:arg1/:arg2/',
                    array(
                            'controller' => 'category',
                            'action'     => ':action',
                            'arg1'       => ':arg1',
                            'arg2'       => ':arg2'
                            )
                    )
         );
    }
    
}

