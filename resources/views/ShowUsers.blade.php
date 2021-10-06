<x-app-layout>

    <x-slot name="header">
    
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Users Details              
                      <table class="table table-sm">
    <thead>
        <tr>
        	<th>Index</th>
            <th>Name</th>
            <th>last Name</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    	<?php $i=1; ?>
        @foreach ($users as $user)
 
        <tr>
        	<td>{{$i}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td> <a href="/testing/{{$user->id}}">{{$user->id}}</a>  </td>
            <td> <a   style="color: red;" href="/Delete/{{$user->id}}">{{$user->id}}</a>  </td>
        </tr>
        <?php $i++ ?>
        @endforeach
    </tbody>
</table>
                </div>


              
            </div>
        </div>
    </div>
</x-app-layout>
