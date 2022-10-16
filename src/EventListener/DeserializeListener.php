<?php
// api/src/EventListener/DeserializeListener.php

namespace App\EventListener;

//use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Core\EventListener\DeserializeListener as DecoratedListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
//use ApiPlatform\Util\RequestAttributesExtractor;
use ApiPlatform\Core\Util\RequestAttributesExtractor;


final class DeserializeListener
{
    private $decorated;
    private $denormalizer;
    private $serializerContextBuilder;

    public function __construct( DenormalizerInterface $denormalizer,DecoratedListener $decorated, SerializerContextBuilderInterface $serializerContextBuilder)
    {
         $this->denormalizer = $denormalizer;
        $this->serializerContextBuilder = $serializerContextBuilder;
        $this->decorated = $decorated; 
    }

    public function onKernelRequest(RequestEvent $event): void {
        $request = $event->getRequest();
        if ($request->isMethodCacheable(false) || $request->isMethod(Request::METHOD_DELETE)) {
            return;
        }

        //dd($request->getContentType());

         //if ('form' === $request->getContentType()) {
        if ('multipart' === $request->getContentType()   ) {

         $this->denormalizeFormRequest($request);
        } 
        else {
            $this->decorated->onKernelRequest($event);
        } 
    }

     private function denormalizeFormRequest(Request $request): void
    {

        $attributes = RequestAttributesExtractor::extractAttributes($request);
        //dd($attributes);
        if(empty($attributes)){
            return ;
        }
        $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
        $populated = $request->attributes->get('data');
        if (null !== $populated) {
            $context['object_to_populate'] = $populated;
        } 

        $data = $request->$request->all();
        $files = $request->files->all();
        dd(array_merge($data , $files));
        dd($context ,$request->attributes);
        $object = $this->denormalizer->denormalize(array_merge($data , $files),  $attributes['resource_class'] ,null, $context);
        dd($object);
        $request->attributes->set('data', $object); 

       /*  if (!$attributes = RequestAttributesExtractor::extractAttributes($request)) {
            return;
        }
        $populated = $request->attributes->get('data');
        if (null !== $populated) {
            $context['object_to_populate'] = $populated;
        }

        $data = $request->request->all();
        $object = $this->denormalizer->denormalize($data, $attributes['resource_class'], null, $context);
        $request->attributes->set('data', $object); */
    } 
}