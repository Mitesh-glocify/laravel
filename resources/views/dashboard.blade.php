<x-app-layout>

    <x-slot name="header">
        <div class="py-6" style="display: flex;" >

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

        </h2>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-nav-link :href="route('user')">   {{ __('Users List') }}</x-nav-link>
        </h2>
        <h2  class="font-semibold text-xl text-gray-800 leading-tight">
         <x-nav-link :href="route('CreateUser')">    {{ __('Create User') }} </x-nav-link>
     </h2>
     <h2  class="font-semibold text-xl text-gray-800 leading-tight">
        <x-nav-link href="{{url('/imageCropper')}}" >Image Cropper</x-nav-link>
    </h2>

</div>
<div class="py-6 col-md-6">


</div>
</x-slot>

</x-app-layout>
