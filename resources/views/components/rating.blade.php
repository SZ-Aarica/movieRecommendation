 @props(['class'=>'flex ml-7 text-2xl'])
 <p {{ $attributes->merge(['class' => $class]) }}>
     <x-star-logo />
     {{$slot}}
 </p>