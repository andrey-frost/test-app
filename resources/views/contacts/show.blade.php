<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact ' . $contact->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>{{ $contact->id }}</p>
                    <p>{{ $contact->first_name }}</p>
                    <p>{{ $contact->email }}</p>
                    <p>{{ $contact->phone }}</p>
                    <p><a href="{{ route('contacts.edit', $contact->id) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Edit</a> <a href="{{ route('contacts.destroy', $contact->id) }}" class="font-medium text-red-600 hover:text-red-500">Delete</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
