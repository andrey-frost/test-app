<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('contacts.create') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                Create
            </a>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @foreach ($contacts as $contact)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p>{{ $contact->id }}</p>
                        <p>{{ $contact->first_name }}</p>
                        <p>{{ $contact->email }}</p>
                        <p>{{ $contact->phone }}</p>
                        <p>
                            <a href="{{ route('contacts.show', $contact->id) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Show</a>
                            <a href="{{ route('contacts.edit', $contact->id) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Edit</a>
                            <a href="{{ route('contacts.destroy', $contact->id) }}" class="font-medium text-red-600 hover:text-red-500">Delete</a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
