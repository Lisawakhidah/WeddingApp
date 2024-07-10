<x-user-layout>
    {{--------------------- 
        $slot 
    --------------------}}
    <h1>Profile Page</h1>
    <p>{{ $user->intro }}</p>
    <h4>{{ $user->mobile }}</h4>
    {{--------------------- 
        $slot 
    --------------------}}
</x-user-layout>