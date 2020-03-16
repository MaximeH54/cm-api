<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class ApiListener
{
		public function onKernelRequest(RequestEvent $event)
		{
				$request = $event->getRequest();
				if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        		$data = json_decode($request->getContent(), true);
        		$request->request->replace(is_array($data) ? $data : array());
    		}
		}
}
